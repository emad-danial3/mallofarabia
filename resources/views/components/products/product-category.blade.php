<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">

                <div class="card-body bg-black" style="background-color: #343a40;">
                    <h3>Category Control</h3>

                @if(isset($categories) )
        <table id="usersTable"  class="table table-bordered table-striped my-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Type</th>
{{--                <th>Control</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $row)
{{--                @if(isset($row->parent))--}}
                <tr>
                    <td>{{$row->id}}</td>
                    <td width="150">{{isset($row->category)?$row->category->name_en:''}}</td>
                    <td width="150">{{(isset($row->category->parent) && $row->category->parent_id== null)?'parent':'child'}}</td>

                    <td>
{{--                        <a class="btn btn-danger" href="{{route('deleteCategoryProduct',$row->id)}}">Delete</a>--}}
{{--                        <a class="btn btn-success" href="{{route('users.show',$row)}}">Show</a>--}}
                    </td>
                </tr>
{{--                @endif--}}
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Type</th>

{{--                <th>Control</th>--}}
            </tr>
            </tfoot>
        </table>
    @endif
        @if(isset($newCategories))
            <form action="{{route('addCategoryProduct')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                    Category
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <select name="category_id" class="form-control col-md-12 col-xs-12">
                        @foreach($newCategories as $category)
                            <option value="{{$category->id}}">
                                @if(isset($category->parent)){{$category->parent->name_en}} @endif=>
                                {{$category->name_en}}

                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="product_id" value="{{$product}}">
{{--                <input type="hidden" name="categories[]" value="{{$data}}">--}}
                <button type="submit" class="btn btn-success my-3 float-right" >Add New Category</button>
            </div>
            </form>
        @endif

</div>
                </div>
                </div>
                </div>
                </div>
</section>
