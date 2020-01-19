<style>
    {{ \File::get(public_path('/css/app.css')) }}
</style>
@foreach($events as $event)
    <div>
        @include('events._event-list-item-simple')
    </div>
@endforeach
