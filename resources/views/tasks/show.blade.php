@extends('layouts.app')
    @section('content')
        <tasks-show :user="user" :current-team="currentTeam" :task-id="{{ $task->id }}" inline-template>
            <div class="container">
                <div class="row" v-if="viewers.length > 1">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Also Viewing</div>

                            <div class="panel-body">
                                <table class="table table-borderless m-b-none">
                                    <thead>
                                    <th></th>
                                    <th>Name</th>
                                    </thead>

                                    <tbody>
                                    <tr v-for="viewer in viewersExceptMe">
                                        <!-- Photo -->
                                        <td>
                                            <img :src="viewer.avatar_url" class="spark-profile-photo">
                                        </td>

                                        <!-- Name -->
                                        <td>
                                            <div class="btn-table-align">
                                                @{{ viewer.name }}
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="task">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">@{{ task.name }}</div>

                            <div class="panel-body">
                                <div v-if="task.information" class="panel-group" id="information">
                                    <div v-for="information in task.information" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse tooltip" title="@{{ information.synopsis }}" data-parent="#information" href="#information-@{{ information.id }}">
                                                    @{{ information.title }}</a>
                                            </h4>
                                        </div>
                                        <div id="information-@{{ information.id }}" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                @{{ information.data }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="m-b-none">
                                    This task was created by @{{ task.creator.name }} on @{{ task.created_at | datetime }}.
                                </p>

                                    <div class="col-lg-4 col-sm-6 text-center">
                                        <div class="well">
                                            <h4>What is on your mind?</h4>
                                            <div class="input-group">
                                                <input type="text" id="userComment" class="form-control input-sm chat-input" placeholder="Write your message here..." />
                                            <span class="input-group-btn" onclick="addComment()">
                                                <a href="#" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-comment"></span> Add Comment</a>
                                            </span>
                                            </div>
                                            <hr>
                                            <ul v-if="task.comments" v-for="comment in task.comments" id="sortable" class="list-unstyled ui-sortable">
                                                <strong class="pull-left primary-font">@{{ comment.title }}</strong>
                                                <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time"></span>@{{ comment.created_at }}</small>
                                                </br>
                                                <li class="ui-state-default">
                                                    @{{ comment.body }}
                                                </li>
                                                </br>
                                            </ul>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </tasks-show>
    @endsection