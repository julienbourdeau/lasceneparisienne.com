<div class="container py-6 px-4 mt-4 md:mt-8 md:py-8 md:px-0 text-sm">
    <div class="flex items-center justify-between flex-wrap flex-col-reverse md:flex-row lg:flex-row">

        <div class="text-gray-500">
            La Scene Parisienne - {{ date('Y') }}
        </div>
        <div class="mb-2 md:mb-0 lg:mb-0">
            <a class="pr-3 md:pr-4 lg:pr-4" href="{{ route('ics') }}">Flux ICS</a>
            <a class="pr-3 md:pr-4 lg:pr-4" href="{{ route('feeds.recently_added') }}">Flux RSS</a>
            <a class="" href="https://www.sigerr.org/journal/lasceneparisienne-a-brief-history-of-the-project">History of the project</a>
        </div>

    </div>
</div>
