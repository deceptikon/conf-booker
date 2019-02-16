export const formatPhone = phone => {
  let res = phone.replace(/\(/g, '')
  res = res.replace(/\)/g, '')
  res = res.replace(/-/g, '')
  res = res.replace(/ /g, '')
  res = res.substring(1);
  return res;
};
