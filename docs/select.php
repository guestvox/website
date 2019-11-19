
php

// $opt_time_zones_america = '<span>{$lang.america}</span>';
// $opt_time_zones_africa = '<span>{$lang.africa}</span>';
// $opt_time_zones_antarctica = '<span>{$lang.antarctica}</span>';
// $opt_time_zones_artic = '<span>{$lang.artic}</span>';
// $opt_time_zones_asia = '<span>{$lang.asia}</span>';
// $opt_time_zones_atlantic = '<span>{$lang.atlantic}</span>';
// $opt_time_zones_australia = '<span>{$lang.australia}</span>';
// $opt_time_zones_europe = '<span>{$lang.europe}</span>';
// $opt_time_zones_indian = '<span>{$lang.indian}</span>';
// $opt_time_zones_pacific = '<span>{$lang.pacific}</span>';
//
// foreach ($this->model->get_time_zones() as $value)
// {
// 	if ($value['zone'] == 'america')
// 		$opt_time_zones_america .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'africa')
// 		$opt_time_zones_africa .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'antarctica')
// 		$opt_time_zones_antarctica .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'artic')
// 		$opt_time_zones_artic .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'asia')
// 		$opt_time_zones_asia .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'atlantic')
// 		$opt_time_zones_atlantic .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'australia')
// 		$opt_time_zones_australia .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'europe')
// 		$opt_time_zones_europe .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'indian')
// 		$opt_time_zones_indian .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// 	if ($value['zone'] == 'pacific')
// 		$opt_time_zones_pacific .= '<a data-select-opt><span data-select-value-1>' . $value['id'] . '</span><span data-select-value-2>' . $value['code'] . '</span></a>';
// }

// '{$opt_time_zones}' => $opt_time_zones_america . $opt_time_zones_africa . $opt_time_zones_antarctica . $opt_time_zones_artic . $opt_time_zones_asia . $opt_time_zones_atlantic . $opt_time_zones_australia . $opt_time_zones_europe . $opt_time_zones_indian . $opt_time_zones_pacific,

js
// $('[data-select-select]').find('[data-select-preview] > [data-select-typer]').on('keyup', function()
// {
//     var input = $(this);
//     var select = input.parents('[data-select-select]');
//     var search = select.find('[data-select-search]');
//     var values = select.find('[data-select-search] > [data-select-opt]');
//
//     $.each(values, function(key, value)
//     {
//         var string1 = value.innerHTML.toLowerCase();
//         var string2 = input.val().toLowerCase();
//         var indexof = string1.indexOf(string2);
//
//         if (indexof >= 0)
//             value.className = '';
//         else
//             value.className = 'hidden';
//     });
//
//     search.addClass('view');
// });

// $('[data-select-select]').find('[data-select-search] > [data-select-opt]').on('click', function()
// {
//     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val($(this).find('[data-select-value-1]').html());
//     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val($(this).find('[data-select-value-2]').html());
//     $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
// });

// $('[data-select-close]').on('click', function(e)
// {
//     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val('');
//     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val('');
//     $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
// });

// $('[data-select-typer]').on('keyup', function(e)
// {
//     if ($(this).val().length <= 0)
//     {
//         $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val('');
//         $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val('');
//         $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
//     }
// });

html
<!-- <div data-select-select>
    <div data-select-preview>
        <input type="text" name="time_zone" data-select-value>
        <input type="text" placeholder="{$lang.time_zone}" data-select-typer>
    </div>
    <div data-select-search>
        <a data-select-close>{$lang.close}</a>
        {$opt_time_zones}
    </div>
</div> -->

css
/* section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] {
    position: relative;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] {
    width: 100%;
    top: 100%;
    position: absolute;
    display: none;
    padding: 20px;
    box-sizing: border-box;
    background-color: #eee;
    z-index: 99;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search].view {
    display: block;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] > span {
    width: 100%;
    display: block;
    margin: 10px 0px;
    font-size: 12px;
    font-weight: 900;
    text-transform: uppercase;
    color: #757575;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] > a {
    width: 100%;
    display: block;
    margin-bottom: 5px;
    padding: 0px 10px;
    box-sizing: border-box;
    font-size: 12px;
    font-weight: 400;
    color: #757575;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] > a:hover {
    cursor: pointer;
    background-color: #e0e0e0;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] > [data-select-close] {
    text-align: right;
    color: #000;
}

section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-preview] > [data-select-value],
section.modal[data-modal="signup"] main > form div.label > label > [data-select-select] > [data-select-search] > a > [data-select-value-1] {
    display: none;
} */
