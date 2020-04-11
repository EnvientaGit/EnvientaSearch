<div id="map-target-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select your a location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="mapTargetForm">
                <div class="modal-body">
                    <div class="form-group">
                        <small id="mapTargetAddressHelp" class="form-text text-muted">Start typing your address, then press ENTER to position the marker on the map. You can refine it by moving the marker. Don’t worry we don’t store your location, but that’s how the search engine works. <strong>Entering the address is important so that the search engine can only list the results that are closest to you.</strong></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="mapTargetAddress" aria-describedby="mapTargetAddressHelp">
                        <div id="maptarget-map-canvas" class="map_canvas"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="mapTargetSaveButton" type="button" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>