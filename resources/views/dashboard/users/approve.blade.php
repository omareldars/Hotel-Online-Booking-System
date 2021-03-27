@if ($approve == 1)
    {{ App\Models\Admin::findOrFail($approved_by)->name  }}
@else
    --
@endif
