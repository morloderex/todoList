@extends('layouts.app')
    @section('content')
        <div class="panel panel-default">
        	<!-- Default panel contents -->
        	<div class="panel-heading">Tasks</div>
            <div v-if="tasks" class="panel-body">
                <!-- Table -->
                <table v-for="task in tasks" class="table table-stripped table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                        <tr>
                            <th>Creator</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@{{ task.name }}</td>
                        </tr>
                        <tr>
                            <td>@{{ task.creator.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endsection