<?php

namespace App\Notifications;

use App\Broadcasting\CustomWebhook;
use App\Broadcasting\OneSingleChannel;
use App\Broadcasting\FcmChannel;
use App\Mail\MailMailableSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\NotificationTemplate\Models\NotificationTemplate;
use Spatie\WebhookServer\WebhookCall;
use Benwilkins\FCM\Message;

class CommonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $type;

    public $data;

    public $subject;

    public $notification;

    public $notification_message;

    public $notification_link;

    public $appData;

    public $custom_webhook;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data)
    {

        $this->type = $type;
        $this->data = $data;
        $this->notification = NotificationTemplate::where('type', $this->type)->with('defaultNotificationTemplateMap')->first();
        $this->subject = $this->notification->defaultNotificationTemplateMap->subject;
        $this->type = ucwords(str_replace('_', ' ', $this->notification->type)) . '!';
        $this->notification_message = $this->notification->defaultNotificationTemplateMap->notification_message;
        $this->notification_link = $this->notification->defaultNotificationTemplateMap->notification_link;
        foreach ($this->data as $key => $value) {
            $this->subject = str_replace('[[ '.$key.' ]]', $this->data[$key], $this->subject);
            $this->notification_message = str_replace('[[ '.$key.' ]]', $this->data[$key], $this->notification_message);
            $this->notification_link = str_replace('[[ '.$key.' ]]', $this->data[$key], $this->notification_link);
        }

        $this->subject = $this->subject != '' ? $this->subject : 'None';
        $this->notification_message = $this->notification_message != '' ? $this->notification_message : __('messages.default_notification_body');

        $this->appData = $this->notification->channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

       
        $notificationSettings = $this->appData;
        $notification_settings = [];
        $notification_access = isset($notificationSettings[$this->type]) ? $notificationSettings[$this->type] : [];


        if (isset($notificationSettings)) {
            foreach ($notificationSettings as $key => $notification) {
             
                if ($notification) {

                    switch ($key) {
                        case 'PUSH_NOTIFICATION':

                                array_push($notification_settings, FcmChannel::class);
                            break;

                        case 'IS_CUSTOM_WEBHOOK':
                            if (setting('is_custom_webhook_notification') == 1) {
                                array_push($notification_settings, CustomWebhook::class);
                            }

                            break;
                    }
                }
            }
        }

        return array_merge($notification_settings, ['database']);
    }

    public function toFcm($notifiable)
    {
        $msg = $this->subject;
        if (! isset($msg) && $msg == '') {
            $msg = __('message.notification_body');
        }
        $type = 'booking';
        if (isset($this->data['type']) && $this->data['type'] !== '') {
            $type = $this->data['type'];
        }
        $heading = $this->type;

        return fcm([
            'to'=>'/topics/user_'.$notifiable->id,
            'collapse_key' => 'type_a',
            'notification' => [
                'body' =>  $msg,
                'title' => $heading ,
            ],
            'data' => [
               'type' => $this->subject,
               'additional_data' => $this->data
            ],
        ]);
    }

    /**
     * Get mail notification
     *
     * @param  mixed  $notifiable
     * @return MailMailableSend
     */
    public function toMail($notifiable)
    {
        $email = '';

        if (isset($notifiable->email)) {
            $email = $notifiable->email;
        } else {
            $email = $notifiable->routes['mail'];
        }

        return (new MailMailableSend($this->notification, $this->data, $this->type))->to($email)
            ->bcc(isset($this->notification->bcc) ? json_decode($this->notification->bcc) : [])
            ->cc(isset($this->notification->cc) ? json_decode($this->notification->cc) : [])
            ->subject($this->subject);
    }

    public function toWebhook($notifiable)
    {
        $key = setting('custom_webhook_content_key');
        $url = setting('custom_webhook_url');
        $secrate_key = setting('app_name');
        $msg = 'Subject: '.$this->subject."\nDescription: ".strip_tags($this->notification_message)."\n".'Link: '.$this->notification_link;

        return WebhookCall::create()
            ->url($url)
            ->payload([$key => $msg])
            ->useSecret($secrate_key)
            ->dispatch();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'data' => $this->data,
        ];
    }
}
