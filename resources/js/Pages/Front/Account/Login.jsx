import React from "react";
import { Link, useForm, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
    });

    const { props } = usePage();
    const flashError = props.flash?.error;
    const translations = props.translations;

    const [showPassword, setShowPassword] = React.useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("account.authenticate"));
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
                    {translations["SKIP"]}
                </Link>
            </div>
            {/* Login form section */}
            <section className="form-section px-15 top-space section-b-space">
                <h1>{translations["Hey, Login Now"]}</h1>

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
                            placeholder={translations["Username or Email"]}
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            required
                        />
                        <label htmlFor="email">
                            {translations["Username or Email"]}
                        </label>
                        {errors.email && (
                            <div className="text-danger small mt-1">
                                {errors.email}
                            </div>
                        )}
                    </div>

                    {/* Password */}
                    <div className="form-floating mb-2 position-relative">
                        <input
                            type={showPassword ? "text" : "password"}
                            className="form-control"
                            id="password"
                            placeholder={translations["Password"]}
                            value={data.password}
                            onChange={(e) =>
                                setData("password", e.target.value)
                            }
                            required
                        />
                        <label htmlFor="password">
                            {translations["Password"]}
                        </label>
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
                                className={`bi ${
                                    showPassword ? "bi-eye-slash" : "bi-eye"
                                }`}
                            ></i>
                        </span>
                        {errors.password && (
                            <div className="text-danger small mt-1">
                                {errors.password}
                            </div>
                        )}
                    </div>

                    {/* Submit */}
                    <button
                        type="submit"
                        className="btn btn-solid w-100"
                        disabled={processing}
                    >
                        {processing
                            ? translations["Signing in..."]
                            : translations["Sign in"]}
                    </button>
                </form>

                {/* Divider */}
                <div className="or-divider">
                    <span>{translations["Or sign in with"]}</span>
                </div>

                {/* Social login */}
                <div className="social-auth">
                    <ul>
                        <li>
                            <a href={route("auth.google")}>
                                <img
                                    src="/front-assets/images/social/google.png"
                                    className="img-fluid"
                                    alt="Google"
                                />
                            </a>
                        </li>
                        <li>
                            <a href={route("auth.facebook")}>
                                <img
                                    src="/front-assets/images/social/fb.png"
                                    className="img-fluid"
                                    alt="Facebook"
                                />
                            </a>
                        </li>
                    </ul>
                </div>

                {/* Bottom link */}
                <div className="bottom-detail text-center mt-3">
                    <h4 className="content-color">
                        {translations["If you are new, Create Now"]}
                    </h4>
                </div>
            </section>
            <section className="panel-space"></section>
        </>
    );
}
