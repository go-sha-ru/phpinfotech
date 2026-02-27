<?php

namespace app\controllers;

use app\models\Books;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays report.
     *
     * @return Response|string
     */
    public function actionIndex($year=null)
    {
        $years = (new \yii\db\Query())
            ->select(['year_of_publication'])
            ->from('books')
            ->groupBy(['year_of_publication'])
            ->orderBy('year_of_publication')
            ->all();

        $book = new Books();


        if ($book->load(Yii::$app->request->post()))
        {
            $year = $book->year_of_publication;
        } else {
            $year = $years[0]['year_of_publication'];
        }

        $authors = (new \yii\db\Query())
            ->select(['a.first_name', 'a.last_name', 'a.patronymic_name', 'b.title', 'ab.author_id'])
            ->from('books b')
            ->innerJoin('authorBooks ab', 'b.id = ab.book_id')
            ->innerJoin('author a', 'a.id = ab.author_id')
            ->where(['b.year_of_publication' => $year])
            ->limit(Yii::$app->params['limitAuthors']);

        $model = new Books();
        $dataProvider = new ActiveDataProvider([
            'query' => $authors,
            'pagination' => [
                'pageSize' => Yii::$app->params['limitAuthors'],
            ],
        ]);
        return $this->render('index', [
            'year' => $year,
            'years' => $years,
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
