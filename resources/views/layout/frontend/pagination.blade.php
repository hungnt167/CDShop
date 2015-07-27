@if($total_page>1)
    <!-- Pagination -->
    <div class="row text-center">
        <div class="col-lg-12">
            <ul class="pagination">
                <li>
                    @if($current_page>1)
                        <a href="{{url().$path.'1'}}">First</a>
                        <a href="{{url().$path.($current_page-1)}}">&laquo;</a>
                    @endif
                </li>

                @for($i=1;$i<=$total_page;$i++)
                    <li
                    @if($i==$current_page)
                        class="active"
                            @endif
                            >
                        <a href="{{url().$path.($i)}}">{{$i}}</a>
                    </li>
                @endfor
                <li>
                    @if($total_page-$current_page>0)
                        <a href="{{url().$path.($current_page+1)}}">&raquo;</a>
                        <a href="{{url().$path.($total_page)}}">Last</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
@endif