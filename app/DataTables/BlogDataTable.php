<?php

namespace App\DataTables;

use App\Models\Blog;
use App\Models\Tag;
use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function (Blog $blog) {
                return '<div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class=" dropdown-item" style="margin-right: 5px"
                                                href="' . route('edit.post', $blog->slug) . '"><i
                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>

                                            <a class="dropdown-item" style="margin-right: 5px" href="javascript:void(0);"
                                                onclick="deleteRecord(\'' . $blog->slug . '\');"><i
                                                    class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>

                                        </div>
                                    </div>';
            })
            ->editColumn('content', function (Blog $blog) {
                return '<p style="word-break: break-all;"' . $blog->content . '</p>';
            })
            ->addColumn('tags', function (Blog $blog) {
                $tags = json_decode($blog->tags);
                $tag_name = Tag::whereIn('id', $tags)
                    ->get()
                    ->pluck('name');

                return collect($tag_name)->implode(' ,');
            })
            ->addColumn('categories', function (Blog $blog) {
                $category = json_decode($blog->category);
                $category_name = Category::whereIn('id', $category)
                    ->get()
                    ->pluck('name');
                return collect($category_name)->implode(' ,');
            })
            ->addColumn('image', function (Blog $blog) {
                return '<img src="' . asset('images/' . $blog->image) . '" alt="" height="100" width="100">';
            })
            ->rawColumns(['content', 'action', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
    {
        if (auth()->user()->role != "admin") {
            return Blog::where('user_id', auth()->user()->id);
        } else {
            return Blog::latest();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)

            ->buttons(

                Button::make('print'),

                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id'),

            Column::make('title'),
            Column::make('content'),
            Column::make('tags'),

            Column::make('categories'),
            Column::make('image'),
            Column::computed('action'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Blog_' . date('YmdHis');
    }
}
