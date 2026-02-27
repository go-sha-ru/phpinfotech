<?php
namespace app\jobs;

use app\models\Books;
use app\models\Subscriptions;
use yii\base\BaseObject;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\queue\JobInterface;


class SendNewBookNotification extends BaseObject implements JobInterface
{

    public Books $book;

    public function execute($queue)
    {
        $authors_ids = $this->book->authors_ids;
        $api_key = \Yii::$app->params['api_key'];
        $subscriptions = Subscriptions::find()->where(['in', 'author_id', $authors_ids])->with('author')->asArray()->all();
        $url = Url::to(['books/view', 'id' => $this->book->id]);
        $send = [
            'apikey' => $api_key,
            'from' => 'INFORM',
            'send' => [],
        ];
        $idx = 1;
        foreach ($subscriptions as $s) {
            $send['send'] += [
                'id' => $idx,
                'to' => $s['phone'],
                'text' => 'Новая книга '. $this->book->title . ' автора ' . $s['author']['last_name'] . ' ' . $s['author']['first_name']
            ];
        }
        $result = file_get_contents('https://smspilot.ru/api2.php', false, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode( $send ),
            ),
        )));

    }

}