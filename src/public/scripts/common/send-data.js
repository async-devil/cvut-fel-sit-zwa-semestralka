/**
 * @param {String} method
 * @param {String} url
 * @param {Object} dto
 */
export async function sendData(method, url, dto) {
  try {
    const response = await fetch(url, {
      method,
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(dto),
    });

    const responseData = await response.json();

    return {
      code: response.status,
      data: responseData,
    };
  } catch (error) {
    console.error(error);
  }
}
