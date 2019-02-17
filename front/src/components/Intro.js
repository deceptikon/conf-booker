import React from 'react';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';

const style = {
  logo : {
    width: '120px',
    float: 'left',
  },
  cnt: {
    float: 'right', 
    width: '120px'
  },
};

export const InfoBlock = () => {

  return (
    <React.Fragment>

      <Grid
        container
        direction="row"
        justify="center"
        alignItems="center"
      >
        <Grid
          justify="center"
          item xs
        >
          <img src="./img/logo.jpg" alt=""  style={style.logo}/>
        </Grid>
        <Grid
          justify="center"
        item xs
        >
  
        </Grid>
        <Grid
          justify="center"
        item xs
        >
          <div style={style.cnt}>
            <span style={{ color: 'crimson', textTransform: 'uppercase', fontSize: '24px' }}>90 лет</span> <br/>
            <span style={{ textTransform: 'uppercase', fontSize: '12px' }}>
            радиологии Кыргызстана
          </span>
        </div>
        </Grid>
      </Grid>
      <br /> <br />


<Typography color="primary" gutterBottom variant="h5" component="h3">
      Ежегодный Международный Конгресс Радиологов
      </Typography>

      <Typography gutterBottom variant="h4" color="primary" component="h1">
      &laquo;Мультимодальные подходы в диагностической визуализации&raquo;
      </Typography>


      <Typography gutterBottom alignCenter variant="h6" color="textSecondary" component="h6">
        14-16 марта 2019 г. <br/>
      </Typography>

      <Typography gutterBottom alignCenter variant="body2" color="textSecondary" component="body2">
        большой конференц-зал <br/> 
Национального Центра Онкологии и Гематологии,<br/> 
  <strong>
    г. Бишкек, ул. Ахунбаева, 92 к.6
  </strong>
  </Typography>


      
      <div className="intro-text">
      В рамках конгресса состоится выставка медицинского оборудования
      <br/>
      <a href="/docs/programme-03-2019.docx" className="MuiButtonBase-root-187 MuiButton-root-161 MuiButton-text-163 MuiButton-textPrimary-164 MuiButton-flat-166 MuiButton-flatPrimary-167" target="_blank">
        Скачать программу конгресса
      </a>
      </div>
    </React.Fragment>
  );
};

const Intro = ({ handler }) => {
  return (
    <Paper style={{padding: '60px 40px'}} >
      <div className="intro">
        <InfoBlock />
        <Button variant="contained" fullWidth color="secondary" gutterBottom onClick={e => handler('primary')}>
          Первичная регистрация
        </Button> &nbsp;
        <Button variant="outlined" fullWidth color="primary" onClick={e => handler('secondary')}>
          Я состою в членах Ассоциации Радиологов КР
        </Button>
      </div>
    </Paper>
  );
};


export default Intro;
