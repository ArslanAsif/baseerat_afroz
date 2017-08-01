@if (count($errors) > 0)
    <div class="alert alert-danger" style="padding-right: 40px">
    	<h4>Error! <span style="float: right; margin-right: -15px">!مسائل</span></h4>
        <ul>
            @if($errors and $errors->has('title'))
				<li>Title is required <span style="float: right">عنوان درکار ہے &nbsp&nbsp•</span></li>
			@endif

			@if($errors and $errors->has('category'))
				<li>Category is required <span style="float: right">قسم درکار ہے &nbsp&nbsp•</span></li>
			@endif

			@if($errors and $errors->has('summary'))
				<li>Summary is required <span style="float: right">خلاصہ درکار ہے &nbsp&nbsp•</span></li>
			@endif

			@if($errors and $errors->has('descr'))
				<li>Description is required <span style="float: right">تفصیل درکار ہے &nbsp&nbsp•</span></li>
			@endif
			@if($errors and $errors->has('image-data'))
				<li>Image is required <span style="float: right">تصویر درکار ہے &nbsp&nbsp•</span></li>
			@endif
        </ul>
    </div>
@endif
