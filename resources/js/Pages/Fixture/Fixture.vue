<template>
    <app-layout title="Fixture">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fixture
            </h2>
            <div>
                <button class="bg-blue-500 shadow-lg shadow-blue-500/50 ...">Set Game</button>
            </div>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="fixture > 0" class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">Match Id</td>
                                <td class="px-4 py-2"><p class="text-right">Home Team</p></td> 
                                <td class="px-4 py-2">|</td> 
                                <td class="px-4 py-2">Away Team</td>
                                <td class="px-4 py-2 pl-8">Is Played</td>
                            </thead>
                            <tbody>
                                <tr v-for="fixture in fixtures" :key="fixture.id">
                                    <td class="px-4 py-2">{{ fixture.id }}</td>
                                    <td class="px-4 py-2"><p class="text-right">{{fixture.home_team.name}} :   {{fixture.home_result}}</p></td> 
                                    <td class="px-4 py-2">|</td>
                                    <td class="px-4 py-2">{{fixture.away_result}} :   {{fixture.away_team.name}} </td>
                                    <td 
                                    class="px-4 py-2 pl-8" 
                                    v-if="fixture.is_played === 'not_played'"
                                    >
                                    <span class="px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded">Not Played</span>
                                    </td>
                                    <td 
                                    class="px-4 py-2 pl-8" 
                                    v-if="fixture.is_played === 'played'"
                                    >
                                    <span class="text-xs px-2 py-0.5 rounded font-bold bg-green-500 text-white">Played</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else>
                        <div id="alert-additional-content-4" class="p-4 mb-4 bg-yellow-100 rounded-lg dark:bg-yellow-200" role="alert">
                            <div class="flex items-center">
                                <svg class="mr-2 w-5 h-5 text-yellow-700 dark:text-yellow-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <h3 class="text-lg font-medium text-yellow-700 dark:text-yellow-800">Warning !</h3>
                            </div>
                            <div class="mt-2 mb-4 text-sm text-yellow-700 dark:text-yellow-800">
                                There are no Fixtures to show. Please open your terminal and run this command.
                            </div>
                        <div class="text-5xl font-extrabold ... text-center">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
                            sail artisan set:fixture
                        </span>
                            </div>
                        </div>
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
        computed : {
            fixture(){
                return this.fixtures.length;
            }
        }
    })
</script>
