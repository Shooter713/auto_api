<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>


</head>
<body>
<div>
    <label for="search">
        Пошук
    </label>
    <input type="text" name="search" id="search">
    <button class="btn btn-primary" id="search-btn">Шукати</button>
</div>
<table>
    <thead>
        <tr class="table-sort">
            <th data-element-sort="@if($sort_key && $sort_key=='id')<?php echo $sort_sort == 'asc' ? 'desc': 'asc'; ?>@else asc @endif" data-element-key="id">id</th>
            <th data-element-sort="@if($sort_key && $sort_key=='user_name')<?php echo $sort_sort == 'asc' ? 'desc': 'asc'; ?>@else asc @endif" data-element-key="user_name">Ім'я</th>
            <th data-element-sort="@if($sort_key && $sort_key=='state_number')<?php echo $sort_sort == 'asc' ? 'desc': 'asc'; ?>@else asc @endif" data-element-key="state_number">Державний номер</th>
            <th data-element-sort="@if($sort_key && $sort_key=='color')<?php echo $sort_sort == 'asc' ? 'desc': 'asc'; ?>@else asc @endif" data-element-key="color">Колір</th>
            <th data-element-sort="@if($sort_key && $sort_key=='vin_code')<?php echo $sort_sort == 'asc' ? 'desc': 'asc'; ?>@else asc @endif" data-element-key="vin_code">Vin Code</th>
            <th style="width: 200px">Дії</th>
        </tr>
    </thead>
    <tbody>
    @foreach($auto as $item)
        <tr data-element-id="{{$item->id}}" class="table_auto{{$item->id}}">
            <td>{{$item->id}}</td>
            <td>{{$item->user_name}}</td>
            <td>{{$item->state_number}}</td>
            <td>{{$item->color}}</td>
            <td>{{$item->vin_code}}</td>
            <td>
                <button class="delete-row-btn" id="delete_button" data-element-id="{{$item->id}}">Видалити</button>
                <button class="edit-row-btn"
                        id="edit_button"
                        data-ellement-vin_code="{{$item->vin_code}}"
                    >Редагувати</button>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

<div class="paginate-table">
    {{$auto->links()}}
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="modal-bg">
    <div class="modal-body">
        <div class="close">х</div>
        <button class="btn btn-success">Зберегти</button>
        <div class="modal-title">Додати</div>
        <div class="modal-section-body">
            <div class="form-group">
                <label for="user_name">
                    <input name="user_name" id="user_name" placeholder="Імя">
                </label>
            </div>
            <div class="form-group">
                <label for="state_number">
                    <input name="state_number" id="state_number" placeholder="Державний номер">
                </label>
            </div>
            <div class="form-group">
                <label for="color">
                    <input name="color" id="color" placeholder="Колір">
                </label>
            </div>
            <div class="form-group">
                <label for="vin_code">
                    <input name="vin_code" id="vin_code" placeholder="Він код">
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" id="button">Додати</button>
</div>

<script>

    // Додавання нового запису

    $(document).on('click','#button', function(){

        $('.modal-body').css('display', 'block')

    });

    // Редагування поточного запису

    $(document).on('click','#edit_button', function (){

        $('.modal-body').css('display','block')

        let id = $(this).attr('data-ellement-vin_code')

        $('#vin_code').val(id).prop( "disabled", true );


    })

    // Закриваття форми

    $(document).on('click','.close', function(){

        $('.modal-body').css('display', 'none')

    });

    // Додавання (редагування) запису

    $(document).on('click','.btn-success',function (){
        // var id = $('#element-id').val();
        var user_name = $('#user_name').val();
        var state_number = $('#state_number').val();
        var color = $('#color').val();
        var vin_code = $('#vin_code').val();

        if(user_name.length && state_number.length && color.length && vin_code.length){
            $.ajax({
                url: '{{url("/add-auto")}}',
                dataType: 'JSON',
                type: 'POST',
                data: {
                    // id: id,
                    user_name: user_name,
                    state_number: state_number,
                    color: color,
                    vin_code: vin_code,
                    _token: $('input[name=_token]').val(),
                },
                success: function (data) {
                    console.log('success');
                    console.log(data);

                    window.location = window.location

                },
                error: function (data) {
                    console.log(data)
                    console.log("error")
                }
            });
        }});

    // Видалення форми

    $(document).on('click','#delete_button',function (){

        let id = $(this).attr('data-element-id');
        console.log(id);

        $.ajax({
            url: '{{url("/delete")}}',
            dataType: 'JSON',
            type: 'GET',
            data: {
                id: id,
                _token: $('input[name=_token]').val(),
            },
            success: function (data) {
                console.log('success');
                console.log(data);
                $('.table_auto'+id).remove();
            },
            error: function (data) {
                console.log(data)
                console.log("error")
            }
        });
    });

    $(document).on('click', '.table-sort th', function (){
         var sort = $(this).attr('data-element-sort');
         $(this).attr(
             'data-element-sort',
             sort === 'asc' ? 'desc' : 'asc'
         );
         var key = $(this).attr('data-element-key');
         var url = '?key='+key+'&sort='+sort;
         window.location = location.protocol + '//' + location.host+'/'+url;
    })

    $(document).on('click', '#search-btn', function (){
        var search = $('#search').val();
        var url = '?search='+search;
        window.location = location.protocol + '//' + location.host+'/'+url;
    })

</script>


</body>
</html>
