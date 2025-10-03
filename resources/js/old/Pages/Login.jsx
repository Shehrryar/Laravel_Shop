import React, { useState } from "react";
import Layout from "../Layouts/Layout";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";


export default function Login() {
  const { errors, flash } = usePage().props; // errors from backend + flash messages

    const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
    const handleChange = (e) => {      
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    // Send login request to Laravel
    router.post(route("account.authenticate"), formData, {
      onError: (err) => {
        console.error("Validation errors:", err);
      },
      onSuccess: () => {
        console.log("Login successful!");
      },
    });
  };

  



  return (
    <>
      {/* Breadcrumb Section */}
      <section className="section-5 pt-3 pb-3 mb-3 bg-white">
        <div className="container">
          <div className="light-font">
            <ol className="breadcrumb primary-color mb-0">
              <li className="breadcrumb-item">
                <Link className="white-text" href={route("front.home")}>
                  Home
                </Link>
              </li>
              <li className="breadcrumb-item">Login</li>
            </ol>
          </div>
        </div>
      </section>

      {/* Login Form Section */}
      <section className="section-10">
        <div className="container">
          {/* Flash messages */}
          {flash.success && <div className="alert alert-success">{flash.success}</div>}
          {flash.error && <div className="alert alert-danger">{flash.error}</div>}

          <div className="login-form">
            <form onSubmit={handleSubmit}>
              <h4 className="modal-title">Login to Your Account</h4>

              {/* Email field */}
              <div className="form-group">
                <input
                  type="text"
                  name="email"
                  placeholder="Email"
                  className={`form-control ${errors.email ? "is-invalid" : ""}`}
                  value={formData.email}
                  onChange={handleChange}
                />
                {errors.email && (
                  <p className="invalid-feedback">{errors.email}</p>
                )}
              </div>

              {/* Password field */}
              <div className="form-group">
                <input
                  type="password"
                  name="password"
                  placeholder="Password"
                  className={`form-control ${errors.password ? "is-invalid" : ""}`}
                  value={formData.password}
                  onChange={handleChange}
                />
                {errors.password && (
                  <p className="invalid-feedback">{errors.password}</p>
                )}
              </div>

              <div className="form-group small">
                <Link href="" className="forgot-link">
                  Forgot Password?
                </Link>
              </div>

              <input
                type="submit"
                className="btn btn-dark btn-block btn-lg"
                value="Login"
              />

              <hr />

              {/* Social Login */}
              <div className="form-group social-login">
                <a href={route("auth.google")} className="btn btn-success">
                  Login with Google
                </a>
                <a href={route("auth.facebook")} className="btn btn-primary">
                  Login with Facebook
                </a>
              </div>
            </form>

            <div className="text-center small">
              Don’t have an account?{" "}
              <Link href={route("account.register")}>Sign up</Link>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}

// Attach Layout
Login.layout = (page) => <Layout title="Login">{page}</Layout>;
