<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');


        $this->crud->allowAccess('show');
        $this->crud->enableExportButtons();
        // $this->crud->enableDetailsRow();

        $this->crud->addFilter(
            [
                'name'  => 'type_id',
                'type'  => 'select2',
                'label' => 'Status'
            ],
            function () {
                return User::select('type_id')->distinct()->get()->pluck('type_id', 'type_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'type_id', $value);
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
        // CRUD::column('name');
        // CRUD::column('email');
        // CRUD::column('password');

        CRUD::column('fcm');
        CRUD::column('sid');
        CRUD::column('type_id');


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


    // private function getFieldsData($show = FALSE)
    // {
    //     return [

    //         [
    //             'name' => 'title',
    //             'label' => 'title',
    //             'type' => 'text',
    //         ],
    //         [
    //             'label' => "Category",
    //             'type' => 'select',
    //             'name' => 'category_id',
    //             'entity' => 'get_category',
    //             'attribute' => 'name',
    //             'model' => 'App\Models\Category',
    //         ],
    //         // [
    //         //     'name' => 'category_id',
    //         //     'label' => 'Category',
    //         //     'type' => 'number',
    //         // ],
    //         [
    //             'name' => 'body',
    //             'label' => 'body',
    //             'type' => 'ckeditor',
    //         ],
    //         [
    //             'label' => "Post Image",
    //             'name' => "image",
    //             'type' => 'image',
    //             'crop' => true, // set to true to allow cropping, false to disable
    //             'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
    //         ],

    //         // [
    //         //     'name' => 'Category',
    //         //     'label' => 'Category',
    //         //     'type'  => 'radio',
    //         //     'options' => [
    //         //         0 => Category::all()->random()->name,
    //         //         1 => 'Published'
    //         //     ]
    //         // ],
    //         // [
    //         //     'label' => "Article Image",
    //         //     'name' => "image",
    //         //     'type' => 'image',
    //         //     'crop' => true, // set to true to allow cropping, false to disable
    //         //     'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
    //         // ]
    //     ];
    // }
    private function getColumnsData($show = FALSE)
    {
        return [

            [
                'name' => 'type_id',
                'label' => 'Type',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
            // [
            //     'name' => 'Category',
            //     'label' => 'Category',
            //     'type'  => 'radio',
            //     'options' => [
            //         0 => Category::get(0)->name,
            //         1 => 'Published'
            //     ]
            // ],
            // [
            //     'label' => "Article Image",
            //     'name' => "image",
            //     'type' => 'image',
            //     'crop' => true, // set to true to allow cropping, false to disable
            //     'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // ]
        ];
    }
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(UserRequest::class);

        // // CRUD::field('name');
        // // CRUD::field('email');
        // // CRUD::field('password');

        CRUD::field('fcm');
        CRUD::field('sid');
        CRUD::field('type_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
