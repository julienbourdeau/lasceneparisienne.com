<template>
    <ais-instant-search :search-client="searchClient" :index-name="indexName">
        <ais-search-box placeholder="Rechercher un concert" />
        <ais-state-results>
            <template slot-scope="{ query, hits }">
                <!-- First condition -->
                <p  class="search-results-panel" v-if="!hits.length">Aucun concert ni salle pour <q class="italic">{{ query }}</q></p>
                <!-- Second condition -->
                <ais-hits v-else-if="query" class="search-results-panel">
                    <div slot="item" slot-scope="{ item }">
                        <a :href="item.canonical_url" class="block p-2 hover:bg-gray-100 active:bg-gray-100 focus:bg-gray-100">
                            <h6 class="font-semibold">{{ item.name }}</h6>
                            <span class="text-red-700">{{ item.start_date }}</span>
                            <span class="pl-3 text-gray-800">{{ item.venue.name }}</span>
                        </a>
                    </div>
                </ais-hits>
                <!-- Fallback condition -->
                <div v-else />
            </template>
        </ais-state-results>
    </ais-instant-search>
</template>

<script>
  import algoliasearch from 'algoliasearch/lite';

  export default {
    props: ['appId', 'apiKey', 'indexName'],
    data() {
      return {
        searchClient: algoliasearch(
            this.appId,
            this.apiKey,
        ),
      };
    }
  };
</script>
