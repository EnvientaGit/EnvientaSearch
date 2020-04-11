<div id="profile-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ENVIENTA Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="profileForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="profileName">Name</label>
                        <input type="text" class="form-control" id="profileName">
                    </div>
                    <div class="form-group">
                        <label for="profileDescription">Short description</label>
                        <textarea class="form-control" id="profileDescription" rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profileAddress">Your location</label>
                        <input type="text" class="form-control" id="profileAddress" aria-describedby="profileAddressHelp">
                        <small id="profileAddressHelp" class="form-text text-muted">Start typing your address, then press ENTER to position the marker on the map. You can refine it by moving the marker.</strong></small>
                        <div id="profile-map-canvas" class="map_canvas"></div>
                    </div>
                    <div class="form-group">
                        Keywords<br />
                        <small>You have to set at least one keyword if you want to be searchable in our local search engine.</small>
                    </div>
                    <?php foreach ($resource_types as $idx => $resource_type) : ?>
                        <div class="form-group">
                            <!--
                            <label for="profile-<?= $resource_type->key ?>"><?= $resource_type->title ?></label>
                            -->
                            <div class="input-group">
                                <input type="text" class="form-control" id="profile-<?= $resource_type->key ?>-search-input" placeholder="Start typing a keyword" autocomplete="off">
                            </div>
                            <div style="height: 1rem;"></div>
                            <span id="profile-<?= $resource_type->key ?>-taglist-active"></span>
                            <span id="profile-<?= $resource_type->key ?>-taglist"></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="profileSaveButton" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>