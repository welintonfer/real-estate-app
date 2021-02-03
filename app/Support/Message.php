<?php


namespace LaraDev\Support;


class Message
{
    private $text;
    private $type;

    public function getText()
    {
        return $this->text;
    }

    public function getType()
    {
        return $this->type;
    }

    public function primary(string $message): Message
    {
        $this->type = 'primary';
        $this->text = $message;
        return $this;
    }

    public function secondary(string $message): Message
    {
        $this->type = 'secondary';
        $this->text = $message;
        return $this;
    }

//    public function danger(string $message): Message
//    {
//        $this->type = 'danger';
//        $this->text = $message;
//        return $this;
//    }

    public function warning(string $message): Message
    {
        $this->type = 'warning';
        $this->text = $message;
        return $this;
    }

    public function info(string $message): Message
    {
        $this->type = 'info';
        $this->text = $message;
        return $this;
    }

    public function success(string $message): Message
    {
        $this->type = 'success';
        $this->text = $message;
        return $this;
    }

    public function error(string $message): Message
    {
        $this->type = 'error';
        $this->text = $message;
        return $this;
    }

    public function render()
    {
        return "<div class='message {$this->getType()}'>{$this->getText()}</div>";
    }
}
