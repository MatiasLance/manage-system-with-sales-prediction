<div class="py-3 py-md-5" id="loginForm">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
        <!-- Card Container -->
        <div class="bg-custom-white p-4 p-md-5 rounded shadow-sm">
          <div class="text-center mb-4">
            <!-- Logo -->
            <img 
              id="adminLoginFormLogo" 
              src="https://i.imgur.com/3LvoZ6D.png" 
              alt="Goat Farm Logo" 
              width="175" 
              height="157" 
              class="mb-3"
            >
            <!-- Heading -->
            <h2 class="fw-bold heading-title">Cashier Login</h2>
            <p class="text-muted">Please enter your credentials to access the POS</p>
          </div>

          <!-- Form -->
          <form id="login">
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <!-- Email Field -->
              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                      <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"></path>
                    </svg>
                  </span>
                  <input 
                    type="email" 
                    class="form-control border-start-0" 
                    name="email" 
                    id="email" 
                    placeholder="Enter your email" 
                    required
                  >
                </div>
              </div>

              <!-- Password Field -->
              <div class="col-12">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                      <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"></path>
                      <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                    </svg>
                  </span>
                  <input 
                    type="password" 
                    class="form-control border-start-0" 
                    name="password" 
                    id="password" 
                    placeholder="Enter your password" 
                    required
                  >
                  <span class="input-group-text bg-light cursor-pointer" id="togglePassword">
                    <i class="fas fa-eye"></i>
                  </span>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="col-12">
                <div class="d-flex flex-row-reverse">
                  <button 
                    class="btn btn-custom-primary btn-sm px-4" 
                    type="submit"
                  >
                    Login <i class="fas fa-arrow-right ms-2"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>