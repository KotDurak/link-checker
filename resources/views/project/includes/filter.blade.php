<div class="col-md-12">
    <h4>Фильтры</h4>
    <?php
        $filterArray = [
            'link_status' => 'Link Status',
            'rel_nofollow'  => 'Rel Nofollow',
            'rel_sponsored' => 'Rel Sponsored',
            'rel_ugc'       => 'Rel UGC',
            'content_noindex'   => 'Content Noindex',
            'content_nofollow'  => 'Content Nofollow',
            'content_none'      => 'Content None',
            'content_noarchive' => 'Content Noarchive',
            'noindex'           => 'Noindex',
            'redirect_donor_page'   => 'Redirect Donor Page',
            'redirect_target_url'   => 'Redirect Target Url'
        ];

        $variants = [
            'all'   => 'Все',
            '1'     => 'Да',
            '0'     => 'Нет'
        ];

    ?>
    <form class="filter-forms">
        <div class="row">
            @foreach ($filterArray as $input => $label)
                <div class="col">
                    <?php
                    $requestVal = request()->input('filter.' .  $input, 'all');
                    ?>
                    <div class="form-group">
                        <select name="filter[{{$input}}]" class="form-control">
                            @foreach($variants as $val => $name)
                                <?php
                                $selected = $requestVal == (string)$val ? 'selected="selected"' : '';
                                ?>
                                <option value="{{$val}}" <?= $selected ?>>{{$name}}</option>
                            @endforeach
                        </select>
                        <label class="form-check-label" for="exampleCheck1">{{$label}}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Фильтровать</button>
        </div>

    </form>
</div>