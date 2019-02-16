import React from 'react';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import Button from '@material-ui/core/Button';

export const InfoBlock = () => {

  return (
    <React.Fragment>
      <Typography color="textPrimary" gutterBottom variant="h4" component="h1">
        Конференция по каким то радиологическим штукам
      </Typography>
      <Typography gutterBottom variant="h5" color="textSecondary" component="h3">
        12 апреля 2019 г.
      </Typography>
      <Typography  variant="h6" color="textSecondary" component="div">
        г. Бишкек, ул. Ахунбаева 102/пер. Тыныстанова
      </Typography>
      <div className="intro-text">
        <p> тттттттттттттут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференцииут текст о конференции
        </p>
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
