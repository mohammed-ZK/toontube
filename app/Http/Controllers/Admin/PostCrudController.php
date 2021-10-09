<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;


    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use CrudTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('post', 'posts');

        $this->crud->allowAccess('show');
        $this->crud->addFields($this->getFieldsData(TRUE));
        $this->crud->enableExportButtons();


        // $this->crud->enableDetailsRow();

        // $this->crud->addFilter([
        //     'type'  => 'date',
        //     'name'  => 'date',
        //     'label' => 'Date'
        //   ],
        //     false,
        //   function ($value) { // if the filter is active, apply these constraints
        //     // $this->crud->addClause('where', 'date', $value);
        //   });

        // $this->crud->addField([
        //     'name' => 'category_id',
        //     'label' => 'Category',
        //     'type' => 'select2_from_array',
        //     'options' => $this->Category->getUnallocatedStudies($category_id),
        //     'allows_null' => false,
        //     'hint' => 'Search for the studies you would like to add to this bundle',
        //     'tab' => 'Info',
        //     'allows_multiple' => true
        // ]);


        $this->crud->addFilter(
            [
                'name'  => 'category_id',
                'type'  => 'select2',
                'label' => 'Status'
            ],
            function () {
                return Post::select('category_id')->distinct()->get()->pluck('category_id', 'category_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'category_id', $value);
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

        // $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns($this->getColumnsData(TRUE));
        // CRUD::setFromDb();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {

        CRUD::setValidation(PostRequest::class);

        // CRUD::setFromDb(); // fields
        // CRUD::field('category_id');

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
                'name' => 'title',
                'label' => 'title',
                'type' => 'text',
            ],
            [
                'name' => 'Category',
                'label' => 'Category',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
            [
                'name' => 'body',
                'label' => 'body',
                'type' => 'ckeditor',
            ],
            [
                'label' => "Post Image",
                'name' => "image",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
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
    private function getFieldsData($show = FALSE)
    {
        return [

            [
                'name' => 'title',
                'label' => 'title',
                'type' => 'text',
            ],
            [
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id',
                'entity' => 'category',
                'attribute' => 'name',
                'model' => 'App\Models\Category',
            ],
            // [
            //     'name' => 'category_id',
            //     'label' => 'Category',
            //     'type' => 'number',
            // ],
            [
                'name' => 'body',
                'label' => 'body',
                'type' => 'ckeditor',
            ],
            [
                'label' => "Post Image",
                'name' => "image",
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            ],
            // [
            //     'name' => 'Category',
            //     'label' => 'Category',
            //     'type'  => 'radio',
            //     'options' => [
            //         0 => Category::all()->random()->name,
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
