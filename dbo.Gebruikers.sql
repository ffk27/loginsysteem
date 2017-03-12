/* Microsoft SQL Server */
CREATE TABLE [dbo].[Gebruikers] (
    [Id]             INT            IDENTITY (1, 1) NOT NULL,
    [naam]           NVARCHAR (45)  NOT NULL,
    [gebruikersnaam] NVARCHAR (30)  NOT NULL,
    [niveau]         INT            NOT NULL,
    [email]          NVARCHAR (254) NOT NULL,
    [salt]           CHAR(10)  NOT NULL,
    [hash]           CHAR(64)  NOT NULL,
    [aanmelddatum]   DATETIME       DEFAULT (getdate()) NOT NULL,
    PRIMARY KEY CLUSTERED ([Id] ASC)
);