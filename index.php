<!DOCTYPE html>
<html>
<head>
    <title>Registration Form in Vue</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="page-header text-right"><a href="login.php" class="btn btn-primary">Login</a></h1>
        <div id="register">
            <div class="col-xl-4">
                <div class="live panel panel-success">
                    <div class="live panel-heading"><span class="live glyphicon glyphicon-client"></span> Client Registration</div>
                    <div class="live panel-body">
                        <label>Client Email:</label>
                        <input type="text" class="live form-control" ref="email" v-model="dtlRegInfo.email" v-on:keyup="clientKeycheck">
                        <div class="text-right" v-if="emailErr">
                            <span style="font-size:13px;" style="color: red;">{{ emailErr }}</span>
                        </div>
                        <label>client Password:</label>
                        <input type="password" class="form-control" ref="password" v-model="dtlRegInfo.password" v-on:keyup="clientKeycheck">
                        <div class="text-right" v-if="passErr">
                            <span style="font-size:13px;"style="color: red;">{{ passErr }}</span>
                        </div>
                    </div>
                    <div class="live panel-footer">
                        <button class="live btn btn-default btn-block" @click="clientReg();"><span class="live glyphicon glyphicon-check"></span>Registration</button>
                    </div>
                </div>

                <div class="alert alert-danger text-right" v-if="msgError">
                    <button type="button" class="close" @click="msgCls();"><span aria-hidden="true">×</span></button>
                    <span class="live glyphicon glyphicon-alert" style="color: red;"></span> {{ msgError }}
                </div>

                <div class="alert alert-success text-right" v-if="msgofSuccess">
                    <button type="button" class="close" @click="msgCls();"><span aria-hidden="true">×</span></button>
                    <span class="live glyphicon glyphicon-check"></span> {{ msgofSuccess }}
                </div>

            </div>

            <div class="col-xl-8">
                <h3>Clients Table</h3>
                <table class="table">
                    <thead>
                        <th>Client ID</th>
                        <th>client Email</th>
                        <th>client Password</th>
                    </thead>
                    <tbody>
                        <tr v-for="client in Clients">
                            <td>{{ client.uid }}</td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.password }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        var main = new Vue({
            el: '#register',
            data: {
                msgofSuccess: "",
                msgError: "",
                emailErr: "",
                passErr: "",
                Clients: [],
                dtlRegInfo: {
                    email: '',
                    password: ''
                },
            },

            mounted: function() {
                this.getAllClients(); // Client List are Displayed IN Table
            },

            methods: {
                getAllClients: function() {
                    axios.get('api.php')
                        .then(function(dataRes) {
                            if (dataRes.data.error) {
                                main.msgError = dataRes.data.message;
                            } else {
                                main.Clients = dataRes.data.Clients;
                            }
                        });
                },

                clientReg: function() {
                    //alert('ok');
                    var regForm = main.toFormData(main.dtlRegInfo);
                    axios.post('api.php?do_act=register', regForm)
                        .then(function(dataRes) {
                            console.log(dataRes);
                            if (dataRes.data.email) {
                                main.emailErr = dataRes.data.message;
                                main.emailFocus();
                                main.msgCls();
                            } else if (dataRes.data.password) {
                                main.passErr = dataRes.data.message;
                                main.emailErr = '';
                                main.passFocus();
                                main.msgCls();
                            } else if (dataRes.data.error) {
                                main.msgError = dataRes.data.message;
                                main.emailErr = '';
                                main.passErr = '';
                            } else {
                                main.msgofSuccess = dataRes.data.message;
                                main.dtlRegInfo = {
                                    email: '',
                                    password: ''
                                };
                                main.emailErr = '';
                                main.passErr = '';
                                main.getAllClients();
                            }
                        });
                },

                emailFocus: function() {
                    this.$refs.email.focus();
                },

                passFocus: function() {
                    this.$refs.password.focus();
                },

                clientKeycheck: function(event) {
                    if (event.key == "Enter") {
                        main.clientReg();
                    }
                },

                toFormData: function(obj) {
                    var liveFormData = new FormData();
                    for (var key in obj) {
                        liveFormData.append(key, obj[key]);
                    }
                    console.log("live Data: "+liveFormData);
                    return liveFormData;
                },

                msgCls: function() {
                    main.msgError = '';
                    main.msgofSuccess = '';
                }

            }
        });
    </script>
</body>

</html>