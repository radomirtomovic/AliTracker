import React, {useState} from "react";
import {Formik} from "formik";
import {TextField} from "@material-ui/core";
import {object, string} from "yup";
import axios from '../axios';
import Alert from "@material-ui/lab/Alert";
import Error from "./Error";

const schema = object().shape({
    name: string().trim().required().min(1).max(70),
    surname: string().trim().required().min(1).max(70),
    email: string().trim().required().max(150).email(),
    password: string().trim().required().min(8),
});


const Register = () => {
    const [name] = useState('');
    const [surname] = useState('');
    const [email] = useState('');
    const [password] = useState('');
    const [error, setError] = useState(null);

    const handleRegisterSubmit = (values, {setSubmitting}) => {
        axios.post('/register', values).then((response) => {
            location.href = '/login';
        }).catch((err) => {
            setError(err.response);
        }).finally(() => {
            setSubmitting(false);
        })
    }

    return (
        <Formik
            initialValues={{
                name,
                surname,
                email,
                password,
            }}
            onSubmit={handleRegisterSubmit}
            validationSchema={schema}
        >
            {({
                  values,
                  errors,
                  handleChange,
                  handleBlur,
                  handleSubmit,
                  isSubmitting,
              }) => (
                <>
                    <Error response={error}/>

                    <form className="col s12" method="post" onSubmit={handleSubmit}>
                        <div className="row">
                            <div className="input-field col s12">
                                <TextField
                                    error={!!errors.name}
                                    fullWidth
                                    type='text'
                                    name='name'
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    label='Name'
                                    helperText={errors.name}
                                />
                            </div>
                        </div>
                        <div className="row">
                            <div className="input-field col s12">
                                <TextField
                                    error={!!errors.surname}
                                    fullWidth
                                    type='surname'
                                    name='surname'
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    label='Surname'
                                    helperText={errors.surname}
                                />
                            </div>
                        </div>
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
                            <div className="input-field col s12">
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
                            Register
                        </button>
                    </form>
                </>
            )}
        </Formik>
    )
}

export default Register;
