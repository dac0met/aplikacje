<div class="table-header">
    @php
    $records = $table->getRecords()
    @endphp
    
    @if ($records instanceof \Illuminate\Contracts\Pagination\Paginator)
        <x-filament::pagination
            :extreme-links="true"
            :page-options="[5, 10, 20, 50,]"
            :paginator="$records"
            class="fi-ta-pagination px-3 py-3 sm:px-6"
        />
    @endif
</div>