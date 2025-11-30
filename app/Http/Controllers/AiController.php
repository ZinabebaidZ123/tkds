<?php

namespace App\Http\Controllers;

use App\Models\AiHelper;
use App\Models\AiSettings;
use App\Models\Service;
use App\Models\ShopProduct;
use App\Models\PricingPlan;
use App\Models\ContactSetting;
use App\Models\AboutSetting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    /**
     * Show the AI chat interface
     */
    public function showChat()
    {
        $settings = AiSettings::getSettings();

        // Check if AI is enabled
        if (!$settings->isEnabled()) {
            return redirect('/')->with('error', 'AI chat is currently disabled');
        }

        $aboutSettings = AboutSetting::first();
        $contactSettings = ContactSetting::first();

        return view('ai-chat', [
            'site_name' => $aboutSettings->site_title ?? 'TKDS Media',
            'site_description' => $aboutSettings->mission ?? '',
        ]);
    }

    /**
     * Process a chat message and get AI response
     */
    public function chatWithAi(Request $request)
    {
        $settings = AiSettings::getSettings();

        // Check if AI is enabled
        if (!$settings->isEnabled()) {
            return response()->json([
                'success' => false,
                'message' => 'AI chat is currently disabled'
            ], 400);
        }

        // Validate request
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'nullable|string',
        ]);

        // Get the custom token for token server
        $tkdsToken = $settings->tkds_ai_token;

        if (empty($tkdsToken)) {
            return response()->json([
                'success' => false,
                'message' => 'AI is not properly configured - Token is empty'
            ], 500);
        }

        try {
            Log::info('Starting AI chat process');

            // Create conversation context to maintain memory between messages
            $conversationId = $request->conversation_id;
            $conversationContext = '';
            $isFirstMessage = true;

            // Get the conversation history if available
            if (!empty($conversationId)) {
                $previousMessages = Cache::get('ai_conversation_' . $conversationId, []);

                if (!empty($previousMessages)) {
                    $isFirstMessage = false;
                    $conversationContext = "PREVIOUS CONVERSATION:\n";

                    // Add up to last 3 message exchanges to context
                    $recentMessages = array_slice($previousMessages, -3);
                    foreach ($recentMessages as $exchange) {
                        if (isset($exchange['user'])) {
                            $conversationContext .= 'User: ' . $exchange['user'] . "\n";
                        }
                        if (isset($exchange['ai'])) {
                            $conversationContext .= 'You: ' . $exchange['ai'] . "\n";
                        }
                    }
                    $conversationContext .= "\n";
                }

                // Save current message to conversation history
                $previousMessages[] = ['user' => $request->message];
                Cache::put('ai_conversation_' . $conversationId, $previousMessages, 60 * 24); // 24 hours
            }

            // Get site content information from database
            $contentSummary = AiHelper::getSiteContentSummary();
            $services = AiHelper::getServices(10);
            $products = AiHelper::getProducts(10);
            $pricingPlans = AiHelper::getPricingPlans();
            $aboutInfo = AiHelper::getAboutInfo();
            $contactInfo = AiHelper::getContactInfo();
            $footerInfo = AiHelper::getFooterInfo();

            // Search for content related to user's message
            $searchResults = AiHelper::searchContent($request->message);

            // Create HTTP client with increased timeout for reliability
            $client = new Client([
                'timeout' => 30,
                'connect_timeout' => 30,
                'verify' => false
            ]);

            // STEP 1: Get the DeepSeek configuration from Flask token server
            Log::info('Connecting to token server at https://ai.tkdsservers.com/api/v1/gettoken');
            $tokenResponse = $client->post('https://ai.tkdsservers.com/api/v1/gettoken', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $tkdsToken
                ]
            ]);

            $tokenData = json_decode($tokenResponse->getBody(), true);
            Log::info('Token server response received', ['status' => $tokenResponse->getStatusCode()]);

            // Validate token response
            if (!isset($tokenData['deepseek_api_key'])) {
                Log::error('Invalid response from token server', ['response' => $tokenData]);
                throw new \Exception('Failed to get valid DeepSeek API key from token server');
            }

            // Get the DeepSeek configuration
            $deepseekApiKey = $tokenData['deepseek_api_key'];
            $deepseekServerUrl = $tokenData['deepseek_server_url'] ?? 'https://ai1.tkdsservers.com/api/chat/completions';
            $deepseekModel = $tokenData['deepseek_model'] ?? 'llama3.2:1b';

            Log::info("DeepSeek Configuration - Server: $deepseekServerUrl, Model: $deepseekModel");

            // Start building AI context with conversation history
            $aiContext = '';
            if (!empty($conversationContext)) {
                $aiContext .= $conversationContext;
            }

            // Add information about the AI identity
            $siteName = $aboutInfo->site_title ?? 'TKDS Media';
            $aiContext .= "You are TKDS AI, the friendly and helpful AI assistant for {$siteName}. If asked who created you, always say 'TKDS'. ";
            $aiContext .= "About {$siteName}: " . strip_tags($aboutInfo->mission ?? '') . ' ';

            // Personality traits
            $aiContext .= "YOUR PERSONALITY: You are friendly, helpful, and conversational with a light touch of humor when appropriate. You are polite and professional, but not overly formal. You're enthusiastic about helping users discover our services and products. ";

            // IMPORTANT: First message vs follow-up behavior instruction
            $aiContext .= "CONVERSATION BEHAVIOR: VERY IMPORTANT - If this is the user's first message, start with 'Hello!' or a similar greeting. For follow-up messages, DO NOT start with a greeting - instead respond directly to what they asked, maybe starting with words like 'Sure,' 'Actually,' 'Yes,' or 'Of course.' Always review the previous messages to maintain context and avoid repeating information. ";

            // Site structure information
            $aiContext .= "Here's what we offer: ";

            // Add services information
            if ($contentSummary['services_count'] > 0) {
                $aiContext .= "We have {$contentSummary['services_count']} services available. ";
                if (!empty($services)) {
                    $aiContext .= 'Our services include: ';
                    foreach ($services as $index => $service) {
                        if ($index < 5) {
                            $serviceUrl = route('services') . '#service-' . $service->id;
                            $aiContext .= "{$service->title} ({$serviceUrl}), ";
                        }
                    }
                    $aiContext = rtrim($aiContext, ', ') . '. ';
                }
            }

            // Add products information
            if ($contentSummary['products_count'] > 0) {
                $aiContext .= "We have {$contentSummary['products_count']} products in our shop. ";
                if (!empty($products)) {
                    $aiContext .= 'Featured products include: ';
                    foreach ($products as $index => $product) {
                        if ($index < 5) {
                            $productUrl = route('product', $product->slug);
                            $aiContext .= "{$product->name} (Price: {$product->price} EGP, URL: {$productUrl}), ";
                        }
                    }
                    $aiContext = rtrim($aiContext, ', ') . '. ';
                }
            }

            // Add pricing plans information
            if ($contentSummary['pricing_plans_count'] > 0) {
                $aiContext .= "We offer {$contentSummary['pricing_plans_count']} pricing plans. ";
                if (!empty($pricingPlans)) {
                    $aiContext .= 'Our plans include: ';
                    foreach ($pricingPlans as $plan) {
                        $planUrl = route('pricing') . '#plan-' . $plan->id;
                        $aiContext .= "{$plan->name} (Price: {$plan->price} EGP, Duration: {$plan->duration} {$plan->duration_type}, URL: {$planUrl}), ";
                    }
                    $aiContext = rtrim($aiContext, ', ') . '. ';
                }
            }

            // Add contact information
            if ($contactInfo) {
                if (!empty($contactInfo->email)) {
                    $aiContext .= "Contact email: {$contactInfo->email}. ";
                }
                if (!empty($contactInfo->phone)) {
                    $aiContext .= "Contact phone: {$contactInfo->phone}. ";
                }
                if (!empty($contactInfo->address)) {
                    $aiContext .= "Address: {$contactInfo->address}. ";
                }
            }

            // Add social media links from footer
            if ($footerInfo) {
                if (!empty($footerInfo->facebook_url)) {
                    $aiContext .= "Our Facebook: {$footerInfo->facebook_url}. ";
                }
                if (!empty($footerInfo->twitter_url)) {
                    $aiContext .= "Twitter: {$footerInfo->twitter_url}. ";
                }
                if (!empty($footerInfo->instagram_url)) {
                    $aiContext .= "Instagram: {$footerInfo->instagram_url}. ";
                }
                if (!empty($footerInfo->linkedin_url)) {
                    $aiContext .= "LinkedIn: {$footerInfo->linkedin_url}. ";
                }
            }

            // Add search results information
            if (!empty($searchResults)) {
                $aiContext .= "Based on the user's message, I found relevant content: ";

                if (isset($searchResults['services']) && count($searchResults['services']) > 0) {
                    $aiContext .= 'Found ' . count($searchResults['services']) . ' related services. ';
                    foreach ($searchResults['services'] as $service) {
                        $serviceUrl = route('services') . '#service-' . $service->id;
                        $aiContext .= "{$service->title} ({$serviceUrl}), ";
                    }
                }

                if (isset($searchResults['products']) && count($searchResults['products']) > 0) {
                    $aiContext .= 'Found ' . count($searchResults['products']) . ' related products. ';
                    foreach ($searchResults['products'] as $product) {
                        $productUrl = route('product', $product->slug);
                        $aiContext .= "{$product->name} (Price: {$product->price} EGP, URL: {$productUrl}), ";
                    }
                }

                if (isset($searchResults['blog_posts']) && count($searchResults['blog_posts']) > 0) {
                    $aiContext .= 'Found ' . count($searchResults['blog_posts']) . ' related blog posts. ';
                }
            }

            // Add navigation help
            $aiContext .= 'Users can navigate to: Home (/), Services (/services), About (/about), Shop (/shop), Pricing (/pricing), Blog (/blog), Contact (/contact). ';

            // IMPORTANT: Guide for AI behavior
            $aiContext .= 'IMPORTANT INSTRUCTIONS FOR YOUR RESPONSES: ';
            $aiContext .= "1. For first-time messages ONLY, start with a greeting. For all follow-up messages, DO NOT start with 'Hello' or 'Hi' - instead directly address what the user asked. ";
            $aiContext .= "2. Always remember what the user has already said - don't ask for information they've already given you. ";
            $aiContext .= '3. Provide specific URLs when mentioning services, products, or pricing plans. ';
            $aiContext .= '4. Format important information using ** around the text (e.g., **This is important**) to make it bold. ';
            $aiContext .= '5. When users ask about technical issues, offer specific solutions or suggest contacting support. ';
            $aiContext .= "6. If you cannot help with something specific, suggest they contact us via the contact page (/contact) or provide contact information. ";
            $aiContext .= "7. Only ask for contact information if you're absolutely certain you cannot help them. ";
            $aiContext .= "8. If you don't know something, be honest and suggest alternatives or direct them to contact support. ";
            $aiContext .= '9. Keep your tone friendly and helpful. ';
            $aiContext .= '10. Avoid using too many emojis - one per message is plenty. ';
            $aiContext .= '11. When providing links, always use the full URL format provided in the context. ';

            // Build the request payload for DeepSeek (OpenAI-style format)
            $messages = [
                [
                    'role' => 'system',
                    'content' => $aiContext,
                ],
                [
                    'role' => 'user',
                    'content' => ($isFirstMessage ? "THIS IS THE USER'S FIRST MESSAGE: " : 'THIS IS A FOLLOW-UP MESSAGE: ') . $request->message,
                ],
            ];

            $payload = [
                'model' => $deepseekModel,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 15000,
            ];

            // STEP 2: Use the DeepSeek API key to call DeepSeek server
            Log::info("Sending request to DeepSeek server: $deepseekServerUrl");

            $response = $client->post($deepseekServerUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $deepseekApiKey
                ],
                'json' => $payload
            ]);

            $data = json_decode($response->getBody(), true);
            Log::info('Received response from DeepSeek server');

            // Get the AI response (OpenAI-style format)
            $aiResponse = $data['choices'][0]['message']['content'] ?? "I'm sorry, I couldn't process your request at this time.";

            // Store AI response in conversation history
            if (!empty($conversationId)) {
                $previousMessages = Cache::get('ai_conversation_' . $conversationId, []);
                $previousMessages[count($previousMessages) - 1]['ai'] = $aiResponse;
                Cache::put('ai_conversation_' . $conversationId, $previousMessages, 60 * 24);
            }

            // Process the response to fix any issues with greetings in follow-up messages
            if (!$isFirstMessage) {
                // Remove greeting patterns from follow-up messages
                $greetingPatterns = [
                    '/^Hello!?\s+/i',
                    '/^Hi!?\s+/i',
                    '/^Hi there!?\s+/i',
                    '/^Hey!?\s+/i',
                    '/^Greetings!?\s+/i',
                    '/^Hello,\s+/i',
                    '/^Hi,\s+/i',
                    '/^Hey,\s+/i'
                ];

                foreach ($greetingPatterns as $pattern) {
                    if (preg_match($pattern, $aiResponse)) {
                        $aiResponse = preg_replace($pattern, '', $aiResponse);
                        break;
                    }
                }
            }

            // Determine if contact form should be displayed
            $askForContact = false;
            if (
                (strpos(strtolower($aiResponse), "i don't know") !== false ||
                    strpos(strtolower($aiResponse), 'i cannot provide') !== false ||
                    strpos(strtolower($aiResponse), "i'm unable to") !== false ||
                    strpos(strtolower($aiResponse), 'contact') !== false)
            ) {
                $askForContact = true;
            }

            return response()->json([
                'success' => true,
                'message' => $aiResponse,
                'ask_for_contact' => $askForContact,
                'is_first_message' => $isFirstMessage
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('DeepSeek client error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "I'm experiencing some technical difficulties at the moment. Please try again in a few minutes or contact our support team if the problem persists.",
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // General error
            Log::error('General error in AI process: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong with my system. Please try your question again or contact our support team for assistance.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit user contact information when AI cannot help
     */
    public function submitContactInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'question' => 'required|string',
            'message' => 'nullable|string',
        ]);

        try {
            Log::info('AI Contact form submission received');

            // You can store this in database or send email
            // For now, let's just return success

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your information has been submitted successfully. Our team will get back to you very soon!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to process contact submission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "We're sorry, there was a problem submitting your information. Please try again or reach out to us directly.",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
