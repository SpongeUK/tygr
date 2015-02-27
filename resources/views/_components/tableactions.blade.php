<div id="table-actions">
    <span class="label"><i class="fa fa-check-square-o"></i> <span id="selectedAmount"></span> issues selected</span>
    <!--a href="" class="action" id="resolve">Resolve</a-->
    <span class="action button-dropdown" id="assign">
        Assign selected <i class="fa fa-caret-up"></i>
        <ul>
            <li>
                <a href="#" id="assign_sponge">
                    <i class="fa fa-angle-right"></i> Sponge UK
                </a>
            </li>
            <li>
                <a href="#" id="assign_client">
                    <i class="fa fa-angle-right"></i> Client
                </a>
            </li>
        </ul>
    </span>
    @if(Auth::user()->rank <= 2)
    <a href="#" class="action" id="claim">Claim issue</a>
    <!--a href="#" class="action button-dropdown" id="version">
        Move version <i class="fa fa-caret-up"></i>
        <ul>
        @foreach($versions as $version)
            <li onclick="document.location='/projects/'">
                <i class="fa fa-angle-right"></i> {{ $version->version }}
            </li>
        @endforeach
        </ul>
    </a-->
    @endif
    @if(Auth::user()->rank == 1)
    <a href="" class="action" id="delete">Delete issue</a>
    @endif
</div>
