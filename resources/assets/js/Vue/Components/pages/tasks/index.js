Vue.component('home', {
    props: ['user', 'currentTeam'],

    /**
     * All of the component's data.
     */
    data() {
        return {
            tasks: []
        };
    },


    /**
     * Prepare the component.
     */
    ready() {
        this.listen();

        this.getTasks();
    },


    methods: {
        /**
         * Listen to the Echo channels.
         */
        listen() {
            echo.private('teams.' + this.currentTeam.id + '.tasks')
                .listen('TaskCreated', event => {
                    this.tasks.push(event.task);
                })
                .listen('TaskDeleted', event => {
                    this.removeTaskFromData(event.taskId);
                })
                .listen('TaskUpdated', event => {
                    this.removeTaskFromData(event.task.id);
                    this.tasks.push(event.task);
                });
        },


        /**
         * Get all of the tasks for the team.
         */
        getTasks() {
            this.$http.get('/api/teams/' + this.currentTeam.id + '/tasks')
                .then(response => {
                    this.tasks = response.data;
                });
        },


        /**
         * Create a fresh task.
         */
        create() {
            this.$http.post('/api/teams/' + this.currentTeam.id + '/tasks', this.form)
                .then(task => {
                    this.form.name = '';

                    this.tasks.push(task);
                });
        },


        /**
         * Delete the given task.
         */
        delete(task) {
            this.$http.delete('/api/teams/' + this.currentTeam.id + '/tasks/' + task.id);

            this.removeTaskFromData(task.id);
        },

        update(task, data) {
            //
        },


        /**
         * Remove the task from the component's data.
         */
        removeTaskFromData(taskId) {
            this.tasks = _.reject(this.tasks, t => t.id == taskId);
        }
    }
});