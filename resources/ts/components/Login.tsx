import React, {useState} from 'react';
import {string, object} from 'yup';
import {Formik} from 'formik';
import {TextField} from "@material-ui/core";
import axios from 'axios';
import Error from "./Error";

const schema = object().shape({
    email: string()
        .required('Email field is required')
        .email('Your input is not valid email')
        .max(150, 'Email field cannot be longer than 150 characters')
        .trim(),
    password: string()
        .required()
        .min(8)
        .trim()
})


const Login = () => {
    const [email] = useState('');
    const [password] = useState('');

    const [error, setError] = useState(null);

    const handleLoginSubmit = (values, {setSubmitting}) => {
        axios.post('/login', values)
            .then((res) => {
                localStorage.setItem('user', JSON.stringify(res.data));
                location.href = '/';
            })
            .catch(err => {
                setError(err.response)
                setSubmitting(false);
            });
    }

    return (
        <Formik
            initialValues={{email, password}}
            onSubmit={handleLoginSubmit}
            validationSchema={schema}
        >
            {({
                  errors,
                  handleChange,
                  handleBlur,
                  handleSubmit,
                  isSubmitting,
              }) => (
                <>
                    <Error response={error}/>
                    <form id="login-form" className="col s12" method="post" onSubmit={handleSubmit}>
                        <div className="row">
                            <div className="input-field col s12">
                                <TextField
                                    error={!!errors.email}
                                    fullWidth
                                    type='email'
                                    name='email'
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    label='Email'
                                    helperText={errors.email}
                                />
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12 ">
                                <TextField
                                    error={!!errors.password}
                                    fullWidth
                                    type='password'
                                    name='password'
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    label='Password'
                                    helperText={errors.password}
                                />
                            </div>
                        </div>
                        <button
                            className="btn waves-effect waves-light"
                            type="submit"
                            disabled={isSubmitting}
                        >
                            Login
                        </button>
                    </form>
                </>
            )}
        </Formik>
    );
};

export default Login;