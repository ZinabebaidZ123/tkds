<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BlogPost;

class NewBlogPostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public BlogPost $post)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Article Published: ' . $this->post->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter.new-blog-post',
            with: [
                'post' => $this->post,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}