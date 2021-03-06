<?php
/**
 * Created by PhpStorm.
 * User: gallant
 * Date: 3/26/17
 * Time: 9:59 PM
 */

namespace frontend\models;

use yii\db\ActiveRecord;
use frontend\models\Book;
use common\models\User;

class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    public function getAuthor()
    {
      return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
