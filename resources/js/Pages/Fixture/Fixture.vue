<template>
    <app-layout title="Fixture">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fixture
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">Match Id</td>
                                <td class="px-4 py-2"><p class="text-right">Home Team</p></td> 
                                <td class="px-4 py-2">|</td> 
                                <td class="px-4 py-2">Away Team</td>
                                <td class="px-4 py-2"></td>
                            </thead>
                            <tbody>
                                <tr v-for="fixture in fixtures" :key="fixture.id">
                                    <td class="px-4 py-2">{{ fixture.id }}</td>
                                    <td class="px-4 py-2"><p class="text-right">{{fixture.home_team.name}} :   {{fixture.home_result}}</p></td> 
                                    <td class="px-4 py-2">|</td>
                                    <td class="px-4 py-2">{{fixture.away_result}} :   {{fixture.away_team.name}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        props : ['fixtures'],
        components: {
            AppLayout,
        },
    })
</script>
