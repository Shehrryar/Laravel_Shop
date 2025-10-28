import React from "react";
import { Link, useForm } from "@inertiajs/react";
import { route } from "ziggy-js";

export default function Signup() {
  const { data, setData, post, processing, errors } = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [showPassword, setShowPassword] = React.useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = React.useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route("account.processRegister"));
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
        <Link href="/">
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
        <Link className="skip-cls" href="/">
          SKIP
        </Link>
      </div>

      {/* Signup form */}
      <section className="form-section px-15 top-space section-b-space">
        <h1>
          Hey, <br /> Sign Up
        </h1>

        <form onSubmit={handleSubmit} className="theme-form">
          {/* Name */}
          <div className="form-floating mb-4">
            <input
              type="text"
              className="form-control"
              id="name"
              placeholder="Name"
              value={data.name}
              onChange={(e) => setData("name", e.target.value)}
              required
            />
            <label htmlFor="name">Name</label>
            {errors.name && <div className="text-danger small">{errors.name}</div>}
          </div>

          {/* Email */}
          <div className="form-floating mb-4">
            <input
              type="email"
              className="form-control"
              id="email"
              placeholder="Email"
              value={data.email}
              onChange={(e) => setData("email", e.target.value)}
              required
            />
            <label htmlFor="email">Email</label>
            {errors.email && <div className="text-danger small">{errors.email}</div>}
          </div>

          {/* Password */}
          <div className="form-floating mb-4 position-relative">
            <input
              type={showPassword ? "text" : "password"}
              id="password"
              className="form-control"
              placeholder="Password"
              value={data.password}
              onChange={(e) => setData("password", e.target.value)}
              required
            />
            <label htmlFor="password">Password</label>
            <button
              type="button"
              onClick={() => setShowPassword(!showPassword)}
              className="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
              tabIndex={-1}
            >
              <i
                className={`iconly-${showPassword ? "Show" : "Hide"} icli`}
                style={{ fontSize: "1.2rem", color: "#555" }}
              ></i>
            </button>
            {errors.password && (
              <div className="text-danger small">{errors.password}</div>
            )}
          </div>

          {/* Confirm Password */}
          <div className="form-floating mb-4 position-relative">
            <input
              type={showConfirmPassword ? "text" : "password"}
              id="password_confirmation"
              className="form-control"
              placeholder="Confirm Password"
              value={data.password_confirmation}
              onChange={(e) => setData("password_confirmation", e.target.value)}
              required
            />
            <label htmlFor="password_confirmation">Confirm Password</label>
            <button
              type="button"
              onClick={() => setShowConfirmPassword(!showConfirmPassword)}
              className="btn position-absolute end-0 top-50 translate-middle-y pe-3 border-0 bg-transparent"
              tabIndex={-1}
            >
              <i
                className={`iconly-${showConfirmPassword ? "Show" : "Hide"} icli`}
                style={{ fontSize: "1.2rem", color: "#555" }}
              ></i>
            </button>
          </div>

          {/* Submit */}
          <button
            type="submit"
            className="btn btn-solid w-100"
            disabled={processing}
          >
            {processing ? "Signing up..." : "Sign Up"}
          </button>
        </form>

        {/* Divider */}
        <div className="or-divider">
          <span>Or sign in with</span>
        </div>

        {/* Social Login */}
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

        {/* Bottom text */}
        <div className="bottom-detail text-center mt-3">
          <h4 className="content-color">
            Already have an Account?{" "}
            <Link
              className="title-color text-decoration-underline"
              href={route("account.login")}
            >
              Sign In
            </Link>
          </h4>
        </div>
      </section>

      {/* Panel space */}
      <section className="panel-space"></section>
    </>
  );
}
