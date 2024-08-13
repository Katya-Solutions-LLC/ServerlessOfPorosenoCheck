<template>
  <form>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-first-name" class="form-label">First Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="admin-first-name" placeholder="Enter Your First Name" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="admin-last-name" placeholder="Enter Your Last Name" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-username" class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="admin-username" placeholder="Enter Your Username" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-email" class="form-label">E-mail <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="admin-email" placeholder="Enter Your E-mail" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-password" class="form-label">Password <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="admin-password" placeholder="Enter Your Password" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="admin-confirm-password" placeholder="Enter Your Confirm Password" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-phone-number" class="form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" id="admin-phone-number" placeholder="Enter Your Phone Number" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-dob" class="form-label">DOB <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="admin-dob" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-gender" class="form-label">Gender <span class="text-danger">*</span></label>
          <select name="gender" id="admin-gender" class="form-control">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="admin-profile" class="form-label">Profile <small>(Optinal)</small> </label>
          <input type="file" class="form-control" id="admin-profile" />
        </div>
      </div>
    </div>
  </form>
</template>
