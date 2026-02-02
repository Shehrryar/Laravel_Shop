import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

const ProfileSettings = () => {
  const { translations, user, errors } = usePage().props;
  const [showPassword, setShowPassword] = useState(false);

  // Local form data
  const [formData, setFormData] = useState({
    first_name: user?.first_name ?? "",
    last_name: user?.last_name ?? "",
    dob: user?.date_of_birth ?? "",
    gender: user?.gender ?? "",
    mobile_number: user?.phone ?? "",
    password: "",
  });

  //  Handle input changes
  const handleChange = (e) => {
    const { id, value } = e.target;
    setFormData((prev) => ({ ...prev, [id]: value }));
  };

  //  Toggle password visibility
  const togglePassword = (e) => {
    e.preventDefault();
    setShowPassword(!showPassword);
  };

  //  Submit to Laravel
  const handleSubmit = (e) => {
    e.preventDefault();
    router.put(route("account.updateProfileData"), formData, {
      onStart: () => console.log("Updating profile..."),
      onSuccess: () => console.log("Profile updated successfully!"),
      onError: (err) => console.error("Update failed:", err),
    });
  };

  return (
    <>
      {/* Header */}
      <header>
        <div className="back-links">
          <Link href={route("account.profile")}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>{translations["Profile Setting"]}</h2>
            </div>
          </Link>
        </div>
      </header>

      {/* Avatar */}
      <section className="user-avtar-section top-space pt-0 px-15">
        <img
          src="/front-assets/images/user/1.png"
          className="img-fluid"
          alt="User"
        />
        <span className="edit-icon">
          <i className="iconly-Edit-Square icli"></i>
        </span>
      </section>

      {/* Personal Details */}
      <section className="detail-form-section px-15">
        <h2 className="page-title mb-4">{translations["Personal Details"]}</h2>

        <form onSubmit={handleSubmit}>
          {/* First Name */}
          <div className="form-floating mb-4">
            <input
              type="text"
              className={`form-control ${errors.first_name ? "is-invalid" : ""}`}
              id="first_name"
              placeholder="First Name"
              value={formData.first_name}
              onChange={handleChange}
              autoComplete="given-name"
            />
            <label htmlFor="first_name">{translations["First Name"]}</label>
            {errors.first_name && (
              <div className="invalid-feedback d-block">
                {errors.first_name}
              </div>
            )}
          </div>

          {/* Last Name */}
          <div className="form-floating mb-4">
            <input
              type="text"
              className={`form-control ${errors.last_name ? "is-invalid" : ""}`}
              id="last_name"
              placeholder="Last Name"
              value={formData.last_name}
              onChange={handleChange}
              autoComplete="family-name"
            />
            <label htmlFor="last_name">{translations["Last Name"]}</label>
            {errors.last_name && (
              <div className="invalid-feedback d-block">
                {errors.last_name}
              </div>
            )}
          </div>

          {/* DOB */}
          <div className="form-floating mb-4">
            <input
              type="date"
              className={`form-control ${errors.dob ? "is-invalid" : ""}`}
              id="dob"
              placeholder="Date of Birth"
              value={formData.dob}
              onChange={handleChange}
              autoComplete="bday"
            />
            <label htmlFor="dob">{translations["Date of Birth"]}</label>
            {errors.dob && (
              <div className="invalid-feedback d-block">{errors.dob}</div>
            )}
          </div>

          {/* Gender */}
          <div className="form-floating mb-4">
            <select
              className={`form-select ${errors.gender ? "is-invalid" : ""}`}
              id="gender"
              value={formData.gender}
              onChange={handleChange}
            >
              <option value="">{translations["Select Gender"]}</option>
              <option value="male">{translations["Men"]}</option>
              <option value="female">{translations["Women"]}</option>
              <option value="other">{translations["Other"]}</option>
            </select>
            <label htmlFor="gender">{translations["Gender"]}</label>
            {errors.gender && (
              <div className="invalid-feedback d-block">{errors.gender}</div>
            )}
          </div>

          <div className="divider"></div>

          {/* Mobile */}
          <div className="form-floating mb-4 position-relative">
            <input
              type="number"
              className={`form-control ${
                errors.mobile_number ? "is-invalid" : ""
              }`}
              id="mobile_number"
              placeholder="Mobile Number"
              value={formData.mobile_number}
              onChange={handleChange}
              autoComplete="tel"
            />
            <label htmlFor="mobile_number">{translations["Mobile Number"]}</label>
            {errors.mobile_number && (
              <div className="invalid-feedback d-block">
                {errors.mobile_number}
              </div>
            )}
          </div>

          {/* Password */}
          <div className="form-floating mb-4 position-relative">
            <input
              type={showPassword ? "text" : "password"}
              className={`form-control ${errors.password ? "is-invalid" : ""}`}
              id="password"
              placeholder="Password"
              value={formData.password}
              onChange={handleChange}
              autoComplete="new-password"
            />
            <label htmlFor="password">{translations["Password"]}</label>
            <a href="#" className="change-btn" onClick={togglePassword}>
              {showPassword ? translations["Hide"] : translations["Show"]}
            </a>
            {errors.password && (
              <div className="invalid-feedback d-block">{errors.password}</div>
            )}
          </div>

          {/* Bottom Buttons */}
          <div className="cart-bottom row m-0">
            <div className="d-flex w-100">
              <div className="left-content col-5">
                <Link href={route('account.profile')} className="title-color">
                  {translations["CANCEL"]}
                </Link>
              </div>
              <button
                type="submit"
                className="btn btn-solid col-7 text-uppercase"
              >
                {translations["Save Details"]}
              </button>
            </div>
          </div>
        </form>
      </section>

      {/* Panel Space */}
      <section className="panel-space"></section>
    </>
  );
};

export default ProfileSettings;
