<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $year_of_publication
 * @property string $isbn
 * @property string|null $cover
 * @property string|null $created_at
 * @property string|null $updated_at
 * // * @property Author[] $authors_ids
 *
 * @property AuthorBooks[] $authorBooks
 */
class Books extends \yii\db\ActiveRecord
{

    public array $authors_ids = [];

    /**
     * @var UploadedFile
     */
    public $imageFile;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'cover'], 'default', 'value' => null],
            [['title', 'year_of_publication', 'isbn'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['description'], 'string'],
            [['year_of_publication'], 'integer'],
            [['created_at', 'updated_at', 'authors_ids'], 'safe'],
            [['title', 'isbn', 'cover'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Краткое описание',
            'year_of_publication' => 'Дата публикации',
            'isbn' => 'Isbn',
            'cover' => 'Обложка',
            'authors_ids' => 'authors_ids',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBooks::class, ['book_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->cover = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->save();
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }


}
