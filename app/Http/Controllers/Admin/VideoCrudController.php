<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VideoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VideoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    // use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Video::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/video');
        CRUD::setEntityNameStrings('video', 'videos');
        $this->crud->addFields($this->getFieldsData(TRUE));


        $this->crud->allowAccess('show');
        $this->crud->enableExportButtons();
        // $this->crud->enableDetailsRow();

        $this->crud->addFilter(
            [
                'name'  => 'series_id',
                'type'  => 'select2',
                'label' => 'Status'
            ],
            function () {
                return Video::select('series_id')->distinct()->get()->pluck('series_id', 'series_id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'series_id', $value);
            }
        );
    }

    public function getFieldsData()
    {

        return [

            [
                'name' => 'URL',
                'label' => 'URL',
                'type' => 'video',
            ], [   // Time
                'name'  => 'title',
                'label' => 'Title',
                'type'  => 'text'
            ], [   // Time
                'name'  => 'series_id',
                'label' => 'Series',
                'type'  => 'select',
                'entity' => 'series',
                'attribute' => 'name',
                'model' => 'App\Models\Serie',
            ], [   // Time
                'name'  => 'intro_start',
                'label' => 'intro_start',
                'type'  => 'time',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6'
                 ],
            ], [   // Time
                'name'  => 'intro_end',
                'label' => 'intro_end',
                'type'  => 'time',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6'
                 ],
            ], [   // Time
                'name'  => 'outro_start',
                'label' => 'outro_start',
                'type'  => 'time',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6'
                 ],
            ], [   // Time
                'name'  => 'outro_end',
                'label' => 'outro_end',
                'type'  => 'time',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6'
                 ],
            ],
        ];
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
        CRUD::addColumns(['title', 'series_id', 'URL', 'intro_start', 'intro_end', 'outro_start', 'outro_end']);
        // CRUD::removeColumn('series_id');

        $this->crud->addColumns($this->getColumnsData(TRUE));
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation 
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns(['title', 'series_id', 'URL', 'intro_start', 'intro_end', 'outro_start', 'outro_end']);
    }

    private function getColumnsData($show = FALSE)
    {
        return [

            [
                'name' => 'series_id',
                'label' => 'series',
                'type'     => 'relationship',
                'function' => function ($entry) {
                    return  $entry->name;
                }
            ],
        ];
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VideoRequest::class);

        CRUD::setFromDb(); // fields

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
