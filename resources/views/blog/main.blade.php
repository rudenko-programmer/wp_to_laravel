@extends('blog.layout')
@section('content')
    <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">

        <!-- Blog Full Post
        ================================================== -->
        <div class="span12">

            <!-- Blog Post 1 -->
            <article>
                <h3>Главная страница</h3>
                <div class="post-content">
                    <div id="root">
                        <ul>
                            <li v-for="name in names" v-text="name"></li>
                        </ul>
                        <input type="text" id="input" v-model="newName">
                        <input type="button" @click="addName" value="add name">
                    </div>
                </div>
            </article>

            <script>
                var app = new Vue({
                    el: '#root',
                    data: {
                        newName:'',
                        names: ['Максим', 'Сергей', 'Генадий']
                    },
                    methods:{
                        addName(){
                            this.names.unshift(this.newName)
                            this.newName = '';
                        }
                    },
                    mounted(){
                        /*document.querySelector('#button').addEventListener('click', function () {
                            let name = document.querySelector('#input');
                            if (name.value != '') {
                                app.names.push(name.value);
                                name.value = '';
                            }
                        });*/
                    }
                });


            </script>

        </div>

    </div>
@endsection