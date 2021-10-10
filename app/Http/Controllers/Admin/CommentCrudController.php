<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;


    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Comment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/comment');
        CRUD::setEntityNameStrings('comment', 'comments');

        $this->crud->allowAccess('show');
        $this->crud->enableExportButtons();
        // $this->crud->enableDetailsRow();

        $this->crud->addFields($this->getFieldsData(TRUE));

        $this->crud->addFilter(
            [
                'name'  => 'post_id',
                'type'  => 'select2',
                'label' => 'Post'
            ],
            function () {
                return Comment::select('post_id')->distinct()->get()->pluck('post_id', 'post_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'post_id', $value);
            }
        );

        $this->crud->addFilter(
            [
                'name'  => 'user_id',
                'type'  => 'select2',
                'label' => 'User'
            ],
            function () {
                return Comment::select('user_id')->distinct()->get()->pluck('user_id', 'user_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'user_id', $value);
            }
        );
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        $this->crud->addColumns($this->getColumnsData(TRUE));
        
        CRUD::addColumn('body');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CommentRequest::class);

        CRUD::setFromDb(); // fields

        // CRUD::addField('body');
        // $this->crud->addFields($this->getFieldsData(TRUE));

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }
    private function getColumnsData($show = FALSE)
    {
        return [

            [
                'name' => 'Post',
                'label' => 'Post',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
            [
                'name' => 'User',
                'label' => 'user',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
        ];
    }


    private function getFieldsData($show = FALSE)
    {
        return [

            [
                'name' => 'body',
                'label' => 'Body',
                'type' => 'text',
            ], 
            [
                'label' => "User",
                'type' => 'select',
                'name' => 'user_id',
                'default'=>101,
                'entity' => 'user',
                'attribute' => 'name',
                'model' => 'App\Models\User',
                'attributes' => [
                    'readonly'    => 'readonly',
                    // 'disabled'    => 'disabled',
                  ],
            ], 
            [
                'label' => "Post",
                'type' => 'select',
                'name' => 'post_id',
                'entity' => 'post',
                'attribute' => 'title',
                'model' => 'App\Models\Post',
            ],
        ];
    }
    
    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation 
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns(['post_id','user_id','body']);
        
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
