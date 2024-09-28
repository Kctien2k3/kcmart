@if ($cat_parent->childs->count())
    <ul class="sub-menu">
        @foreach ($cat_parent->childs as $child)
            @if ($child->category_status == 'published')
                <li>
                    <a href="{{ route('product.category', ['category_slug' => $child->category_slug]) }}" title="">{{ $child['category_name'] }}</a>
                    @if ($child->childs->count())
                        @include('layouts.child_menu', ['cat_parent' => $child])
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
