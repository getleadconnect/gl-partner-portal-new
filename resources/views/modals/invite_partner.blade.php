<div class="modal fade bs-example-modal-new gl-invite-modal" id="invite_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="body-message">
                    <h3>Invite Partner</h3>
                </div>
                <form class="invite-form">
                    <p id="email_label">Enter Email-Id</p>
                    <label class="control-label error-class hidden" id="inputError">Please input a valid email-id</label>
                    <div class="form-fields">
                        <input type="email" id="email_id" placeholder="contact@gmail.com">
                        <button type="button" id="send_invitation">Invite now</button>
                    </div>
                </form>
                <div class="link-copy-col">
                    <h4>Share read-only link</h4>
                    <div class="read-only-col">
                        <div class="r-only-link">
                            <input type="text" id="link" value="https://gl-partner/partner/accept-invitation/i5rGqlnuzbfe" readonly>
                        </div>
                        <div id="copy">
                            <button data-copytarget="#link">Copy link</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>