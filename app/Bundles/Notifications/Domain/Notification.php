<?php


namespace App\Bundles\Notifications\Domain;


class Notification
{
    private $title;
    private $details;
    private $topic_id;
    private $activity_id;

    public function __construct($title, $details, $topic_id, $activity_id)
    {
        $this->title = $title;
        $this->details = $details;
        $this->topic_id = $topic_id;
        $this->activity_id = $activity_id;
    }

    public function toPrimitives(): array
    {
        return [
            'title' => $this->title,
            'details' => $this->details,
            'topic_id' => $this->topic_id,
            'activity_id' => $this->activity_id,
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function details(): string
    {
        return $this->details;
    }

    public function topic_id(): string
    {
        return $this->topic_id;
    }

    public function activity_id(): string
    {
        return $this->activity_id;
    }
}
