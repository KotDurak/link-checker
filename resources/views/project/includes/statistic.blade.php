<h3>Статистика</h3>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Найдено</th>
        <th scope="col">Не нейдено</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            {{\Illuminate\Support\Arr::get($statistic, 'found.count')}} &nbsp;
            ({{\Illuminate\Support\Arr::get($statistic, 'found.percent')}} %)
        </td>
        <td>
            {{\Illuminate\Support\Arr::get($statistic, 'not_found.count')}} &nbsp;
            ({{\Illuminate\Support\Arr::get($statistic, 'not_found.percent')}} %)
        </td>
    </tr>
    </tbody>
</table>