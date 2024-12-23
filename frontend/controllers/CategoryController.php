<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\CategorySearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors() :array
    {
        return array_merge( parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ] );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex() :string
    {
        $searchModel  = new CategorySearch();
        $dataProvider = $searchModel->search( $this->request->queryParams );

        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ] );
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate() :Response|string
    {
        $model = new Category();

        if( $model->load( $this->request->post() ) )
        {
            $model->user_id = Yii::$app->user->id;

            if( $model->save() )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The category has been saved.' ) );
                return $this->redirect( ['index'] );
            }

            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while saving the category.' ) );
        }

        return $this->render( 'create', [
            'model' => $model,
        ] );
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     *
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionUpdate(int $id) :Response|string
    {
        $model = $this->findModel( $id );

        if( $this->request->isPost )
        {
            if( $model->load( $this->request->post() ) && $model->save() )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The category has been saved.' ) );
                return $this->redirect( ['index'] );
            }

            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while saving the category.' ) );
        }

        return $this->render( 'update', [
            'model' => $model,
        ] );
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id) :Response
    {
        try
        {
            $this->findModel( $id )->delete();
            Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'The category has been deleted.' ) );
        }
        catch( Throwable $e )
        {
            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An error occurred while deleting the category.' ) );
        }

        return $this->redirect( ['index'] );
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id) :Category
    {
        if( ($model = Category::findOne( ['id' => $id] )) !== null )
        {
            return $model;
        }

        throw new NotFoundHttpException( Yii::t( 'common', 'The requested page does not exist.' ) );
    }
}
