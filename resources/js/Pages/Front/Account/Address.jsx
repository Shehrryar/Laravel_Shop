import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
export default function AddAddress() {
    const { user, countries, editaddress } = usePage().props;
    const [selectedCountry, setSelectedCountry] = useState("");
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState({ text: "", type: "" });

    console.log(editaddress);

    const [formData, setFormData] = useState({
        pin_code: editaddress?.pin_code || "",
        flat: editaddress?.flat || "",
        area: editaddress?.area || "",
        landmark: editaddress?.landmark || "",
        city: editaddress?.city || "",
        state: editaddress?.state || "",
        address_type: editaddress?.address_type || "home",
        default: editaddress?.is_default || true,
        firstname: editaddress?.firstname || "",
        lastname: editaddress?.lastname || "",
        email: editaddress?.email || "",
    });

    // const [formData, setFormData] = useState({
    //     pin_code: "",
    //     flat: "",
    //     area: "",
    //     landmark: "",
    //     city: "",
    //     state: "",
    //     address_type: "home",
    //     default: true,
    // });

    const [errors, setErrors] = useState({});
    //  Handle Input Changes
    const handleChange = (e) => {
        const { id, value, type, checked, name } = e.target;
        if (type === "checkbox") {
            setFormData({ ...formData, [name]: checked });
        } else if (type === "radio") {
            setFormData({ ...formData, [name]: value });
        } else {
            setFormData({ ...formData, [id]: value });
        }
        // clear field error on change
        setErrors((prev) => ({ ...prev, [id || name]: "" }));
    };
    // Handle Submit
    const handleSubmit = async (e) => {
        e.preventDefault();
        setMessage({ text: "", type: "" });
        setErrors({});
        // Basic validation
        const newErrors = {};
        if (!selectedCountry) newErrors.country_id = "Country is required";
        if (!formData.pin_code) newErrors.pin_code = "Pin Code is required";
        if (!formData.flat)
            newErrors.flat = "Flat or building info is required";
        if (!formData.area) newErrors.area = "Area is required";
        if (!formData.city) newErrors.city = "City is required";
        if (!formData.state) newErrors.state = "State is required";
        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }
        setLoading(true);
        try {
            const response = await axios.post(route("account.storeAddress"), {
                user_id: user.id,
                country_id: selectedCountry,
                pin_code: formData.pin_code,
                flat: formData.flat,
                area: formData.area,
                landmark: formData.landmark,
                city: formData.city,
                state: formData.state,
                address_type: formData.address_type,
                is_default: formData.default ? 1 : 0,
            });
            console.log(response);
            if (response.data.status) {
                setMessage({
                    text: "✅ Address added successfully!",
                    type: "success",
                });
                setTimeout(() => {
                    router.visit(route("front.checkout"));
                }, 1000);
            } else {
                setMessage({
                    text: "Something went wrong, please try again.",
                    type: "error",
                });
            }
        } catch (error) {
            setMessage({ text: "Error adding address.", type: "error" });
        } finally {
            setLoading(false);
        }
    };
    // ✅ Reset Form
    const handleReset = () => {
        setFormData({
            pin_code: "",
            flat: "",
            area: "",
            landmark: "",
            city: "",
            state: "",
            address_type: "home",
            default: true,
        });
        setSelectedCountry("");
        setErrors({});
        setMessage({ text: "", type: "" });
    };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.cart")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Add a new address</h2>
                        </div>
                    </Link>
                </div>
            </header>
            <form onSubmit={handleSubmit}>
                <section className="top-space pt-2">
                    <div className="address-form-section px-15">
                        {message.text && (
                            <div
                                className={`alert mb-3 ${
                                    message.type === "success"
                                        ? "alert-success"
                                        : "alert-danger"
                                }`}
                            >
                                {message.text}
                            </div>
                        )}
                        {/* Country Select */}
                        <div className="form-floating mb-4">
                            <select
                                className="form-select"
                                id="country_id"
                                value={selectedCountry}
                                onChange={(e) =>
                                    setSelectedCountry(e.target.value)
                                }
                            >
                                <option value="">Select Country</option>
                                {countries &&
                                    countries.map((country) => (
                                        <option
                                            key={country.id}
                                            value={country.id}
                                        >
                                            {country.name}
                                        </option>
                                    ))}
                            </select>
                            <label htmlFor="country_id">Country/Region</label>
                            {errors.country_id && (
                                <small className="text-danger">
                                    {errors.country_id}
                                </small>
                            )}
                        </div>
                        {/* Name & Phone */}
                        <div className="form-floating mb-4">
                            <input
                                disabled
                                type="text"
                                className="form-control"
                                id="one"
                                placeholder="Full Name"
                                value={user.name}
                            />
                            <label htmlFor="one">Full Name</label>
                        </div>
                        <div className="form-floating mb-4">
                            <input
                                disabled
                                type="number"
                                className="form-control"
                                id="two"
                                placeholder="Mobile Number"
                                value={user.phone}
                            />
                            <label htmlFor="two">Mobile Number</label>
                        </div>
                        {/* Pin Code */}
                        <div className="form-floating mb-4">
                            <input
                                type="number"
                                className="form-control"
                                id="pin_code"
                                placeholder="Pin Code"
                                value={formData.pin_code}
                                onChange={handleChange}
                            />
                            <label htmlFor="pin_code">Pin Code</label>
                            {errors.pin_code && (
                                <small className="text-danger">
                                    {errors.pin_code}
                                </small>
                            )}
                        </div>
                        {/* Flat */}
                        <div className="form-floating mb-4">
                            <input
                                type="text"
                                className="form-control"
                                id="flat"
                                placeholder="Flat, house No., building.."
                                value={formData.flat}
                                onChange={handleChange}
                            />
                            <label htmlFor="flat">
                                Flat, house No., building..
                            </label>
                            {errors.flat && (
                                <small className="text-danger">
                                    {errors.flat}
                                </small>
                            )}
                        </div>
                        {/* Area */}
                        <div className="form-floating mb-4">
                            <input
                                type="text"
                                className="form-control"
                                id="area"
                                placeholder="Area, colony, street"
                                value={formData.area}
                                onChange={handleChange}
                            />
                            <label htmlFor="area">Area, colony, street</label>
                            {errors.area && (
                                <small className="text-danger">
                                    {errors.area}
                                </small>
                            )}
                        </div>
                        {/* Landmark (optional) */}
                        <div className="form-floating mb-4">
                            <input
                                type="text"
                                className="form-control"
                                id="landmark"
                                placeholder="Landmark"
                                value={formData.landmark}
                                onChange={handleChange}
                            />
                            <label htmlFor="landmark">
                                Landmark (optional)
                            </label>
                        </div>
                        {/* City */}
                        <div className="form-floating mb-4">
                            <input
                                type="text"
                                className="form-control"
                                id="city"
                                placeholder="Town/City"
                                value={formData.city}
                                onChange={handleChange}
                            />
                            <label htmlFor="city">Town/City</label>
                            {errors.city && (
                                <small className="text-danger">
                                    {errors.city}
                                </small>
                            )}
                        </div>
                        {/* State */}
                        <div className="form-floating mb-4">
                            <input
                                type="text"
                                className="form-control"
                                id="state"
                                placeholder="State/Province/Region"
                                value={formData.state}
                                onChange={handleChange}
                            />
                            <label htmlFor="state">State/Province/Region</label>
                            {errors.state && (
                                <small className="text-danger">
                                    {errors.state}
                                </small>
                            )}
                        </div>
                    </div>
                    <div className="divider"></div>
                    {/* Address Type */}
                    <div className="type-address px-15">
                        <h2 className="page-title">Type of address</h2>
                        <div className="d-flex flex-wrap">
                            {["home", "office", "others"].map((type) => (
                                <div
                                    key={type}
                                    className="me-3 d-flex align-items-center mb-2"
                                >
                                    <input
                                        className="radio_animated"
                                        type="radio"
                                        name="address_type"
                                        id={type}
                                        value={type}
                                        checked={formData.address_type === type}
                                        onChange={handleChange}
                                    />
                                    <label htmlFor={type} className="ms-1">
                                        {type.charAt(0).toUpperCase() +
                                            type.slice(1)}
                                    </label>
                                </div>
                            ))}
                        </div>
                        {/* Default Address */}
                        <div className="checkbox_animated">
                            <div className="d-flex align-items-center mb-2">
                                <input
                                    type="checkbox"
                                    name="default"
                                    id="ten"
                                    checked={formData.default}
                                    onChange={handleChange}
                                />
                                <label htmlFor="ten" className="ms-1">
                                    Make default address
                                </label>
                            </div>
                        </div>
                    </div>
                </section>
                {/* Bottom Buttons */}
                <div className="cart-bottom row m-0">
                    <div className="col-12 d-flex justify-content-between align-items-center">
                        <button
                            type="button"
                            onClick={handleReset}
                            className="title-color col-5 text-center btn btn-link"
                        >
                            RESET
                        </button>
                        <button
                            type="submit"
                            disabled={loading}
                            className="btn btn-solid col-7 text-uppercase text-center"
                        >
                            {loading ? "Saving..." : "Add Address"}
                        </button>
                    </div>
                </div>
            </form>
        </>
    );
}
