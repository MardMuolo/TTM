<div class="modal fade" @yield('id_modal')>
    <div class="modal-dialog @yield('class-modal')">
        <div class="modal-content">
            <div class="modal-header">
                @yield('modal-title')
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @yield('modal-content')
            </div>
            <div class="modal-footer justify-content-between">
                
                @yield('modal-footer')
                
            </div>
        </div>
    
    </div>    
</div>