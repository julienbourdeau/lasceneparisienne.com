@auth
    <span class="font-medium uppercase text-sm">
        @if(isset($apiResponse) && $apiResponse)
            <span @click="apiResponse = !apiResponse" x-text="!apiResponse ? 'Show json' : 'Hide json'" class="text-green-600 pr-2">Show json</span>
        @endif
        <a href="{{ adminView($model) }}" class="text-blue-600 pr-2">View</a>
        <a href="{{ adminEdit($model) }}" class="text-red-700">Edit</a>
    </span>
@endauth
