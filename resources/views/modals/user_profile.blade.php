<div class="modal fade" id="user-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">User Profile</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="card card-small mb-4">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item p-3">
                            <div class="row">
                              <div class="col">
                                <form>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feFirstName">Name</label>
                                      <input type="text" class="form-control" id="feFirstName" placeholder="Name" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label for="feLastName">Mobile Number</label>
                                      <input type="tel" class="form-control" id="feLastName" placeholder="Mobile Number" minlength=6 maxlength=15 value="">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feEmailAddress">Email</label>
                                      <input type="email" class="form-control" id="feEmailAddress" placeholder="Email" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label for="fePassword">Website</label>
                                      <input type="text" class="form-control" id="Website" placeholder="Website">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feEmailAddress">Company Name</label>
                                      <input type="text" class="form-control" id="company_name" placeholder="Company Name" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label for="fePassword">Team Size</label>
                                      <input type="number" class="form-control" id="team_size" placeholder="Team Size">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label for="feInputCity">Country</label>
                                      <input type="text" class="form-control" id="feInputCity">
                                    </div>
                                    <div class="form-group col-md-4">
                                      <label for="feInputState">State</label>
                                      <select id="feInputState" class="form-control">
                                        <option selected="">Choose...</option>
                                        <option>...</option>
                                      </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                      <label for="inputZip">Pin Code</label>
                                      <input type="number" class="form-control" id="inputZip">
                                    </div>
                                  </div>
                                  {{-- <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="feDescription">Description</label>
                                      <textarea class="form-control" name="feDescription" rows="5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio eaque, quidem, commodi soluta qui quae minima obcaecati quod dolorum sint alias, possimus illum assumenda eligendi cumque?</textarea>
                                    </div>
                                  </div> --}}
                                </form>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>