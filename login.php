<html lang="en">

<head>
    <title>Form Validation With VueJs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
</head>

<body>
    <div class="container" id="app">
        <div class="container">
            <h4 class="text-success">Login Example In VueJs And PHP</h4>
            <div class="panel panel-primary">
                <div class="panel-heading">Login Example In VueJs And PHP</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">UserName:</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="first_name" v-model="user_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Password:</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="password" name="password" v-model="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"> </label>
                        <div class="col-sm-5">
                            <input type="button" @click='login();' value="Login" class="btn btn-primar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                user_name: "",
                password: ""
            },
            methods: {
                login: function() {
                    if (this.username != '' && this.password != '') {
                        axios.post('response.php', {
                                request: 1,
                                username: this.user_name,
                                password: this.password
                            })
                            .then(function(response) {
                                console.log(response);
                                if (response.data[0].status == 1) {
                                    alert('Login Successfully');
                                    
                                    //window.location.href(index.php);
                                } else {
                                    alert("User does not exist");
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    } else {
                        alert('Please enter username & password');
                    }
                }
            }
        })
    </script>
</body>

</html>