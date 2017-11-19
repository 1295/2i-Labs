<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddChat()" class="btn btn-primary btn-xs pull-right">
                            + Add New Chat
                        </button>
                        My Chats
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="chats.length > 0">
                            <tbody>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>
                                    First Name
                                </th>
                                <th>
                                    Last Name
                                </th>
                                <th>
                                    Message
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <tr v-for="(chat, index) in chats">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ chat.first_name }}
                                </td>
                                <td>
                                    {{ chat.last_name }}
                                </td>
                                <td>
                                    {{ chat.message }}
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteChat(index)" class="btn btn-danger btn-xs">Delete</button>
                                    <button @click="allChat(index)" class="btn btn-info btn-xs">All User Chats</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="add_chat_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Chat</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="messenger_user_id" id="messenger_user_id" value="Admin Added" v-model="chat.messenger_user_id">
                        </div>
                        <div class="form-group">
                            <label for="First name">First Name:</label>
                            <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control"
                                   v-model="chat.first_name">
                        </div>
                        
                        <div class="form-group">
                            <label for="Last_name">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control"
                                   v-model="chat.last_name">
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                      placeholder="Chat Message" v-model="chat.message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createChat" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_chat_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Update Chat</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" placeholder="First Name" class="form-control"
                                   v-model="update_chat.first_name">
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" placeholder="Last Name" class="form-control"
                                   v-model="update_chat.last_name">
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea cols="30" rows="5" class="form-control"
                                      placeholder="Chat Message" v-model="update_chat.message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateChat" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="show_chat_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">All User Chat</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <ul>
                              <li v-for="msg in chat">{{ msg.message }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</template>

<script>
    export default {
        data(){
            return {
                chat: {
                    first_name: '',
                    last_name: '',
                    message: ''
                },
                errors: [],
                chats: [],
                update_chat: {},
                show_chat: {
                    message: ''
                }
            }

        },
        mounted()
        {
            this.readChats();
        },
        methods: {
            initAddChat()
            {
                $("#add_chat_model").modal("show");
            },
            createChat()
            {
                axios.post('api/chat', {
                    first_name: this.chat.first_name,
                    last_name: this.chat.last_name,
                    messenger_user_id: "admin",
                    chat_message: this.chat.message,
                })
                    .then(response => {

                        this.reset();

                        this.chats.push(response.data.chat);

                        $("#add_chat_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        

                        if (error.response.data.errors.last_name) {
                            this.errors.push(error.response.data.errors.last_name[0]);
                        }

                        if (error.response.data.errors.first_name) {
                            this.errors.push(error.response.data.errors.first_name[0]);
                        }

                        if (error.response.data.errors.message) {
                            this.errors.push(error.response.data.errors.message[0]);
                        }
                    });
            },
            reset()
            {
                this.chat.first_name = '';
                this.chat.last_name = '';
                this.chat.message = '';
            },
            readChats()
            {
                axios.get('api/chat')
                    .then(response => {

                        this.chats = response.data.chats;

                    });
            },
            allChat(index)
            {
                this.errors = [];
                $("#show_chat_model").modal("show");
                this.show_chat = this.chats[index];
            },
            showChat()
            {
                 axios.get('api/chat/' + this.show_chat.fb_id)
                 .then(response => {

                        this.chats = response.data.show_chats;

                    });
            },
            initUpdate(index)
            {
                this.errors = [];
                $("#update_chat_model").modal("show");
                this.update_chat = this.chats[index];
            },
            updateChat()
            {
                axios.patch('api/chat/' + this.update_chat.id, {
                    first_name: this.update_chat.first_name,
                    last_name: this.update_chat.last_name,
                    messenger_user_id: "admin-updated",
                    message: this.update_chat.message,
                })
                    .then(response => {

                        $("#update_chat_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.first_name) {
                            this.errors.push(error.response.data.errors.first_name[0]);
                        }

                        if (error.response.data.errors.last_name) {
                            this.errors.push(error.response.data.errors.last_name[0]);
                        }

                        if (error.response.data.errors.message) {
                            this.errors.push(error.response.data.errors.message[0]);
                        }
                    });
            },
            deleteChat(index)
            {
                let conf = confirm("Do you ready want to delete this chat?");
                if (conf === true) {
 
                    axios.delete('api/chat/' + this.chats[index].id)
                        .then(response => {
 
                            this.chats.splice(index, 1);
 
                        })
                        .catch(error => {
 
                        });
                }
            }
        }
    }
</script>