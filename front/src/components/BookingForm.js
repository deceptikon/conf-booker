import React from 'react';


import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';

function BookingForm() {
  return (
    <React.Fragment>
     <Typography variant="h4" gutterBottom>
        Регистрация на конференцию
      </Typography>
      <Grid container spacing={24}>
        <Grid item xs={12} md={12}>
          <TextField required id="fullname" label="Полное имя" fullWidth />
        </Grid>
        <Grid item xs={12} md={12}>
          <TextField required id="phone" label="Телефон" fullWidth />
        </Grid>
        <Grid item xs={12} md={12}>
          <TextField required id="email" label="Электронная почта" fullWidth />
        </Grid>
        <Grid item xs={12} md={12}>
          <TextField required id="job_place" label="Место работы" fullWidth />
        </Grid>
        <Grid item xs={12} md={12}>
          <TextField required id="position" label="Должность" fullWidth />
        </Grid>
        <Grid item xs={12} md={12}>
          <TextField 
            required id="speciality" label="Специальность" fullWidth 
            helperText="Если несколько, введите через запятую"
          />
        </Grid>
        <Grid item xs={12}>
          <FormControlLabel
            control={<Checkbox color="secondary" name="agreed" value="yes" />}
            label="Согласен на обработку моих личных данных"
          />
          <Button variant="contained" color="primary">
            Записаться на конференцию
          </Button>
        </Grid>
      </Grid>
    </React.Fragment>
  );
}

export default BookingForm;
