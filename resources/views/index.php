<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currencies</title>
    <link rel="stylesheet" type="text/css" href="<?=asset('css/app.css')?>">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Currencies</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item" v-if="tab" v-for="tab in tabs"
                    v-bind:key="tab"
                    v-bind:class="['tab-button', { active: currentTab === tab }]"
                    v-on:click="currentTab = tab"

                ><a class="nav-link" href="#">{{tab}}</a>
                </li>
                <li class="nav-item" @click="logout()" v-if="authentication"><a class="nav-link" href="#">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <component v-bind:is="currentTabComponent">
    </component>
</div>
<script src="<?=asset('js/app.js')?>"></script>
</body>
</html>
