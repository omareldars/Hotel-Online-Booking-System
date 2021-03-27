
@if($banned == 1)
    <a class="btn btn-primary btn-sm mr-1" href="{{ route('dashboard.managers.unbanned', $id) }}">
        <i class="fas fa-folder"> </i> Unban
    </a>
@else
    <a class="btn btn-warning btn-sm mr-1" href="{{ route('dashboard.managers.banned', $id) }}">
        <i class="fas fa-folder"> </i> Ban
    </a>
@endif

<a href="{{ route('dashboard.managers.edit', $id) }}" class="btn-info btn-sm mr-1">
    <i class="fas fa-pencil-alt"> </i> Edit
</a>

<form action="{{ route('dashboard.managers.destroy', $id) }}" method="post"
    style="display: inline-block;">
    {{ csrf_field() }}
    {{ method_field('delete') }}
    <button type="submit" class="btn btn-danger delete btn-sm" onclick="return confirm('Are you sure ?')">
        <i class="fa fa-trash"></i> Del
    </button>
</form><!-- end of form -->
