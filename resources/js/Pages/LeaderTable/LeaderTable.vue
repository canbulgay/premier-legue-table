<template>
    <app-layout title="LeaderTable">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leader Table
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex justify-center">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2">Team Name </td>
                                <td class="px-4 py-2">Played </td>
                                <td class="px-4 py-2">Won </td>
                                <td class="px-4 py-2">Drawn </td>
                                <td class="px-4 py-2">Lost </td>
                                <td class="px-4 py-2">Goals For </td>
                                <td class="px-4 py-2">Goals Against </td>
                                <td class="px-4 py-2">Goal Difference</td>
                                <td class="px-4 py-2">Points</td>

                            </thead>
                            <tbody>
                                <tr v-for="(team,index) in points" :key="team.id">
                                    <td class="px-4 py-2 text-center">{{ index+1}}</td>
                                    <td class="px-4 py-2">{{ team.team.name }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.played }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.won }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.drawn }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.lost }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.goals_for }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.goals_against }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.goal_difference }}</td>
                                    <td class="px-4 py-2 text-center">{{ team.points }}</td>

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
        props : ['points'],
        components: {
            AppLayout,
        },
    })
</script>
