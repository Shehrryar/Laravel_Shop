import React from "react";
import { Link, useForm, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
export default function Login() {
  // ✅ Manage form data with Inertia
  const { data, setData, post, processing, errors } = useForm({
    email: "",
    password: "",
  });
  const { props } = usePage();
  const flashError = props.flash?.error; 





  const [showPassword, setShowPassword] = React.useState(false);
  const handleSubmit = (e) => {
    e.preventDefault();
    post(route("account.authenticate")); // your backend login route
  };
  return (
    <>
      {/* Top design */}
      <img
        src="/front-assets/images/design.svg"
        className="img-fluid design-top"
        alt="Top Design"
      />
      {/* Top bar */}
      <div className="topbar-section">
        <Link href={route("front.home")}>
          <img
            src="/front-assets/images/logo.png"
            className="img-fluid main-logo"
            alt="Main Logo"
          />
          <img
            src="/front-assets/images/logo-white.png"
            className="img-fluid white-logo"
            alt="White Logo"
          />
        </Link>
        <Link className="skip-cls" href={route("front.home")}>
          SKIP
        </Link>
      </div>
      {/* Login form section */}
      <section className="form-section px-15 top-space section-b-space">
        <h1>
          Hey, <br /> Login Now
        </h1>


        {flashError && (
          <div className="alert alert-danger text-center mt-3">
            {flashError}
          </div>
        )}


        
        <form onSubmit={handleSubmit} className="theme-form">
          {/* Email / Username */}
          <div className="form-floating mb-4">
            <input
              type="text"
              className="form-control"
              id="email"
              placeholder="Username or Email"
              value={data.email}
              onChange={(e) => setData("email", e.target.value)}
              required
            />
            <label htmlFor="email">Username or Email</label>
            {errors.email && (
              <div className="text-danger small mt-1">{errors.email}</div>
            )}
          </div>
          {/* Password */}
          <div className="form-floating mb-2 position-relative">
            <input
              type={showPassword ? "text" : "password"}
              className="form-control"
              id="password"
              placeholder="Password"
              value={data.password}
              onChange={(e) => setData("password", e.target.value)}
              required
            />
            <label htmlFor="password">Password</label>
            {/* Eye icon toggle */}
            <span
              onClick={() => setShowPassword(!showPassword)}
              style={{
                position: "absolute",
                top: "50%",
                right: "15px",
                transform: "translateY(-50%)",
                cursor: "pointer",
                color: "#888",
              }}
            >
              <i
                className={`bi ${showPassword ? "bi-eye-slash" : "bi-eye"}`}
              ></i>
            </span>
            {errors.password && (
              <div className="text-danger small mt-1">{errors.password}</div>
            )}
          </div>
          {/* Forgot password */}
          {/* <div className="text-end mb-4">
            <Link href={route("account.forgotPassword")} className="theme-color">
              Forgot Password?
            </Link>
          </div> */}
          {/* Submit */}
          <button
            type="submit"
            className="btn btn-solid w-100"
            disabled={processing}
          >
            {processing ? "Signing in..." : "Sign in"}
          </button>
        </form>
        {/* Divider */}
        <div className="or-divider">
          <span>Or sign in with</span>
        </div>
        {/* Social login */}
        <div className="social-auth">
          <ul>
            <li>
              <a href="#">
                <img
                  src="/front-assets/images/social/google.png"
                  className="img-fluid"
                  alt="Google"
                />
              </a>
            </li>
            <li>
              <a href="#">
                <img
                  src="/front-assets/images/social/fb.png"
                  className="img-fluid"
                  alt="Facebook"
                />
              </a>
            </li>
            <li className="apple-icon">
              <a href="#">
                <img
                  src="/front-assets/images/social/apple.png"
                  className="img-fluid"
                  alt="Apple"
                />
              </a>
            </li>
          </ul>
        </div>
        {/* Bottom link */}
        <div className="bottom-detail text-center mt-3">
          <h4 className="content-color">
            If you are new,{" "}
            <Link
              className="title-color text-decoration-underline"
              href={route("account.register")}
            >
              Create Now
            </Link>
          </h4>
        </div>
      </section>
      {/* Panel space */}
      <section className="panel-space"></section>
    </>
  );
}